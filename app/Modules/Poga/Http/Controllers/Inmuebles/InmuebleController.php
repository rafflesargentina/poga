<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarInmueble, BorrarInmueble, CrearInmueble };

use Caffeinated\Shinobi\Models\Role;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class InmuebleController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePadreRepository object.
     *
     * @var InmueblePadreRepository $inmueble
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate(
            $request, [
            'tipoListado' => 'required|in:DisponiblesAdministrar,MisInmuebles,Nominaciones,TodosInmuebles',
            'rol' => 'required_if:tipo_listado,Nominaciones'
            ]
        );

        $items = [];
        $user = $request->user('api');

        switch($request->tipoListado) {
        case 'DisponiblesAdministrar':
            $map = $this->repository->findDisponiblesAdministrar();

            break;

        case 'MisInmuebles':
            $map = $this->repository->findMisInmuebles($user);
                
            break;

        case 'Nominaciones':
            $role = Role::where('slug', $request->rol)->first();

            $items = $this->repository->with('idInmueble.nominaciones')
                ->whereHas('idInmueble', function($query) use($role, $user) {
                    return $query->where('enum_estado', 'ACTIVO')
                        ->has('nominaciones');
//, function($q) use($role, $user) {
                    //return $q->where('role_id', $role->id); });
                })->get();
            //$user->idPersona->whereHas('nominaciones', function($query) { return $query->where('idInmueble.enum_tabla_hija', 'INMUEBLES_PADRE'); });

            $map = $items->map(
                function ($item) {
                        $inmueble = $item->idInmueble;

                        return [
                        'cant_unidades' => $inmueble->unidades->count(),
                        'direccion' => $inmueble->direccion,
                        'divisible_en_unidades' => $item->divisible_en_unidades,
                        'id' => $inmueble->id_inmueble_padre,
                        'id_usuario_creador' => $inmueble->id_usuario_creador,
                        'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                        'nombre' => $inmueble->idInmueblePadre->nombre,
                        'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                        'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                        'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                        'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                        'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                        'tipo' => $inmueble->tipo,
                        ];
                }
            );
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request, [
            'administrador' => 'required',
            'formatos' => 'required|array',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.id_tipo_inmueble' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.nombre' => 'required',
            'idInmueblePadre.cant_pisos' => 'required',
            'idInmueblePadre.comision_administrador' => 'required',
            'idInmueblePadre.modalidad_propiedad' => 'required_if:idInmueble.id_tipo_inmueble,1',
            'idPropietarioReferente' => 'required_if:modalidad_propiedad,UNICO_PROPIETARIO',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $inmueblePadre = $this->dispatch(new CrearInmueble($data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePadre);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        $model->loadMissing('idInmueble.caracteristicas', 'idInmueble.formatos');

        return $this->validSuccessJsonResponse('Success', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request, [
            'formatos' => 'required|array',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.calle_secundaria' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.nombre' => 'required',
            'idInmueblePadre.cant_pisos' => 'required',
            'idInmueblePadre.comision_administrador' => 'required',
            'idInmueblePadre.modalidad_propiedad' => 'required_if:idInmueble.id_tipo_inmueble,1',
            'idPropietarioReferente' => 'required_if:modalidad_propiedad,UNICO_PROPIETARIO',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $model = $this->repository->findOrFail($id);

        $inmueblePadre = $this->dispatch(new ActualizarInmueble($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePadre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inmueblePadre = $this->repository->findOrFail($id);

        $inmueble = $this->dispatch(new BorrarInmueble($inmueblePadre->idInmueble, $request->user('api')));

        return $this->validSuccessJsonResponse('Success');
    }
}
