<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\UnidadRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarUnidad, BorrarUnidad, CrearUnidad };

use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate(
            $request, [
            'idInmueblePadre' => 'required',
            ]
        );

        $items = $this->repository->whereHas('idInmueble', function($query) { return $query->where('inmuebles.enum_estado', 'ACTIVO'); })->where('id_inmueble_padre', $request->idInmueblePadre)->get();

        return $this->validSuccessJsonResponse('Success', $items);
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
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idPropietarioReferente' => 'required',
            'unidad.area_estacionamiento' => 'required',
            'unidad.area' => 'required',
            'unidad.id_formato_inmueble' => 'required',
            'unidad.id_inmueble_padre' => 'required',
            'unidad.numero' => 'required',
            'unidad.piso' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');

        $unidad = $this->dispatch(new CrearUnidad($data, $user));

        return $this->validSuccessJsonResponse('Success', $unidad);
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
        $this->validate($request, [
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idPropietarioReferente' => 'required',
            'unidad.area_estacionamiento' => 'required',
            'unidad.area' => 'required',
            'unidad.id_formato_inmueble' => 'required',
            'unidad.numero' => 'required',
            'unidad.piso' => 'required',
        ]);

        $data = $request->all();
        $user = $request->user('api');
        $model = $this->repository->findOrFail($id);

        $unidad = dispatch(new ActualizarUnidad($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $unidad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        $unidad = $this->dispatch(new BorrarUnidad($model, $request->user('api')));

        return $this->validSuccessJsonResponse('Success', $unidad);
    }
}
