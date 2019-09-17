<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\{ InmueblePadreRepository, NominacionRepository };
use Raffles\Modules\Poga\UseCases\{ ActualizarInmueble, BorrarInmueble, CrearInmueble };

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class InmuebleController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePadreRepository object.
     *
     * @var InmueblePadreRepository
     */
    protected $repository;

    /**
     * Create a new InmuebleController instance.
     *
     * @param InmueblePadreRepository $repository The InmueblePadreRepository object.
     *
     * @return void
     */
    public function __construct(InmueblePadreRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate(
            [
            'tipoListado' => 'required|in:DisponiblesAdministrar,MisInmuebles,Nominaciones,TodosInmuebles',
            'rol' => 'required_if:tipo_listado,Nominaciones'
            ]
        );

        $user = $request->user('api');

        switch ($request->tipoListado) {
        case 'DisponiblesAdministrar':
            $map = $this->repository->findDisponiblesAdministrar();

            break;

        case 'MisInmuebles':
            $map = $this->repository->findMisInmuebles($user);
                
            break;

        case 'Nominaciones':
            $repository = new NominacionRepository;

            $map = $repository->dondeFuiNominado($user->id_persona, $user->role_id);

            break;

        case 'TodosInmuebles':
            $map = $this->repository->findTodos();

            break;
        }

        return $this->validSuccessJsonResponse('Success', $map);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user('api');

        if ($request->administrador === 'yo') {
            $request->merge(['idAdministradorReferente' => $user->id_persona]);
        }

        $request->validate(
            [
            'dia_cobro_mensual' => Rule::requiredIf(
                function () use ($request, $user) {
                    // Requerido cuando la modalidad de la propiedad es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $request->idInmueblePadre['modalidad_propiedad'] === 'EN_CONDOMINIO'
                    && ($request->administrador === 'yo' || $request->idAdministradorReferente == $user->id_persona);
                }
            ),
            'administrador' => 'required|in:yo,otra_persona',
            'formatos' => 'required|array|min:1',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.id_tipo_inmueble' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.cant_pisos' => 'required|numeric',
            'idInmueblePadre.comision_administrador' => Rule::requiredIf(
                function () use ($request) {
                    // Requerido cuando la modalidad de la propiedad es UNICO_PROPIETARIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $request->idInmueblePadre['modalidad_propiedad'] === 'UNICO_PROPIETARIO'
                    && ($request->administrador === 'yo' || $request->idAdministradorReferente == $user->id_persona);
                }
            ),
            'idInmueblePadre.divisible_en_unidades' => 'required_if:idInmueble.id_tipo_inmueble,1',
            'idInmueblePadre.modalidad_propiedad' => 'required_if:idInmueble.id_tipo_inmueble,1',
            'idInmueblePadre.nombre' => 'required',
            'idPropietarioReferente' => Rule::requiredIf(
                function () use ($request, $user) {
                    // Requerido cuando la modalidad de la propiedad es UNICO_PROPIETARIO
                    // y el tipo de inmueble es distinto de Edificio.
                    return $request->idInmueblePadre['modalidad_propiedad'] === 'UNICO_PROPIETARIO'
                    && $request->idInmueble['id_tipo_inmueble'] != '1';
                }
            ),
            'salario' => Rule::requiredIf(
                function () use ($request, $user) {
                    // Requerido cuando la modalidad de la propiedad es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $request->idInmueblePadre['modalidad_propiedad'] === 'EN_CONDOMINIO'
                    && ($request->administrador === 'yo' || $request->idAdministradorReferente == $user->id_persona);
                }
            )
            ]
        );

        $data = $request->all();
        $inmueblePadre = $this->dispatch(new CrearInmueble($data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePadre);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
        $model->loadMissing('idInmueble.caracteristicas', 'idInmueble.formatos');

        $this->authorize($request->user('api'), $model);

        return $this->validSuccessJsonResponse('Success', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
        $data = $request->all();
        $user = $request->user('api');

        // Ciertos campos no se pueden modificar una vez creado el inmueble.
        array_key_exists('divisible_en_unidades', $data['idInmueblePadre']) ?: $data['idInmueblePadre']['divisible_en_unidades'] = $model->divisible_en_unidades;
        array_key_exists('id_tipo_inmueble', $data['idInmueblePadre']) ?: $data['idInmueblePadre']['id_tipo_inmueble'] = $model->id_tipo_inmueble;
        array_key_exists('idAdministradorReferente', $data) ?: $data['idAdministradorReferente'] = ($model->idAdministradorReferente ? $model->idAdministradorReferente->id : null);
        array_key_exists('idPropietarioReferente', $data) ?: $data['idPropietarioReferente'] = ($model->idPropietarioReferente ? $model->idPropietarioReferente->id : null);
        array_key_exists('modalidad_propiedad', $data['idInmueblePadre']) ?: $data['idInmueblePadre']['modalidad_propiedad'] = $model->modalidad_propiedad;

        $request->merge($data);

        return $this->validSuccessJsonResponse('Success', $request->all());
        $request->validate(
            [
            'caracteristicas' => 'array',
            'dia_cobro_mensual' => Rule::requiredIf(
                function () use ($model, $user) {
                    // Requerido cuando la modalidad de la propiedad es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'EN_CONDOMINIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id == $user->id_persona : false);
                }
            ),
            'formatos' => 'required|array|min:1',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.cant_pisos' => 'required|numeric',
            'idInmueblePadre.comision_administrador' => Rule::requiredIf(
                function () use ($model) {
                    // Requerido cuando la modalidad de la propiedad es UNICO_PROPIETARIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'UNICO_PROPIETARIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id == $user->id_persona : false);
                }
            ),
            'idInmueblePadre.nombre' => 'required',
            'salario' => Rule::requiredIf(
                function () use ($model, $user) {
                    // Requerido cuando la modalidad de la propiedad es EN_CONDOMINIO,
                    // y administrador es "yo" o idAdministradorReferente es igual a id_persona del usuario.
                    return $model->modalidad_propiedad === 'EN_CONDOMINIO'
                    && ($model->idAdministradorReferente ? $model->idAdministradorReferente->id == $user->id_persona : false);
                }
            )
            ]
        );

        $inmueblePadre = $this->dispatch(new ActualizarInmueble($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePadre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $inmueblePadre = $this->repository->findOrFail($id);

        $model = $inmueblePadre->idInmueble;
        $user = $request->user('api');
        $inmueble = $this->dispatchNow(new BorrarInmueble($model, $user));

        return $this->validSuccessJsonResponse('Success', $inmueble);
    }
}
