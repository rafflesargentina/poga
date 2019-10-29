<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\{ InmueblePadreRepository, UnidadRepository };
use Raffles\Modules\Poga\UseCases\{ ActualizarUnidad, BorrarUnidad, CrearUnidad };

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class UnidadController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UnidadController instance.
     *
     * @param UnidadRepository $repository
     *
     * @return void
     */
    public function __construct(UnidadRepository $repository)
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
            'idInmueblePadre' => 'required',
            ]
        );

	$user = $request->user('api');

        $items = $this->repository->filter()->sort()->whereHas(
            'idInmueble', function ($query) use($user) {
		 $query->where('inmuebles.enum_estado', 'ACTIVO');

		 switch ($user->role_id) {
		 case 3:
		     $query->whereHas('idInquilinoReferente', function($q) use($user) {
		         $q->where('id_persona', $user->id_persona);
		     });
		 break;
		 case 4:
                     $query->whereHas('idPropietarioReferente', function($q) use($user) {
                         $q->where('id_persona', $user->id_persona);
		     });
		     break;
		 }
            })
	->where('id_inmueble_padre', $request->idInmueblePadre)
	->get();

        return $this->validSuccessJsonResponse('Success', $items);
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

	$rInmueblePadre = new InmueblePadreRepository;
	$inmueblePadre = $rInmueblePadre->findOrFail($request->unidad['id_inmueble_padre']);

	if ($inmueblePadre->modalidad_propiedad === 'UNICO_PROPIETARIO') {
            $request->merge(['idPropietarioReferente' => $inmueblePadre->idInmueble->idPropietarioReferente->id_persona]);
	}

        $request->validate(
            [
            'administrador' => 'required|in:yo,otra_persona',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueble.id_tipo_inmueble' => 'required',
            'idPropietarioReferente' => Rule::requiredIf(
                function () use ($inmueblePadre) {
                    // Requerido sólo cuando la modalidad del inmueble padre es EN_CONDOMINIO.
                    return $inmueblePadre->modalidad_propiedad === 'EN_CONDOMINIO';
                }
            ),
            'unidad.area_estacionamiento' => 'numeric',
            'unidad.area' => 'required',
            'unidad.id_formato_inmueble' => 'required',
            'unidad.id_inmueble_padre' => 'required',
            'unidad.numero' => 'required',
            'unidad.piso' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');

        $unidad = $this->dispatchNow(new CrearUnidad($data, $user));

        return $this->validSuccessJsonResponse('Success', $unidad);
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
        $inmueblePadre = $model->idInmueblePadre;

        $request->validate(
            [
            'caracteristicas' => 'array',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idPropietarioReferente' => Rule::requiredIf(
                function () use ($inmueblePadre) {
                    // Requerido sólo cuando la modalidad del inmueble padre es EN_CONDOMINIO.
                    return $inmueblePadre->modalidad_propiedad === 'EN_CONDOMINIO';
                }
            ),
            'unidad.area_estacionamiento' => 'numeric',
            'unidad.area' => 'required',
            'unidad.id_formato_inmueble' => 'required',
            'unidad.numero' => 'required',
            'unidad.piso' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');

        $unidad = $this->dispatchNow(new ActualizarUnidad($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $unidad);
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
        $model = $this->repository->findOrFail($id);
        $user = $request->user('api');

        $unidad = $this->dispatchNow(new BorrarUnidad($model, $user));

        return $this->validSuccessJsonResponse('Success', $unidad);
    }
}
