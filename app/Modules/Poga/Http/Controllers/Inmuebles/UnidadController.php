<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\UnidadRepository;
use Raffles\Modules\Poga\UseCases\{ BorrarUnidad, CrearUnidad };

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

        $items = $this->repository->whereHas('idInmueble', function($query) { return $query->where('enum_estado', 'ACTIVO'); })->where('id_inmueble_padre', $request->idInmueblePadre)->get();

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
            'idPropietarioReferente' => 'required_if:modalidad_propiedad,UNICO_PROPIETARIO',
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

        $model->load('idInmueble.formatos');

        return $this->validSuccessJsonResponse('Success', $model);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'area' => 'required|numeric',
            'area_estacionamiento' => 'numeric',
            'id_medida' => 'required',
            'numero' => 'required',
            'piso' => 'required|numeric',
            'id_inmueble' => [
                'solicitud_directa_inquilinos' => 'boolean',
            ]
            ]
        );

        $model = $this->repository->find($id);
        $model->update(
            [
            'area' => $request->area,
            'area_estacionamiento' => $request->area_estacionamiento,
            'id_medida' => $request->id_medida,
            'numero' => $request->numero,
            'piso' => $request->piso
            ]
        );

        $model->idInmueble->update(
            [
            'solicitud_directa_inquilinos' => $request->id_inmueble->solicitud_directa_inquilinos
            ]
        );

        return $this->validSuccessJsonResponse('Success', $model->refresh());
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
        $unidad = $this->repository->find($id);

        if (!$unidad) {
            abort(404);
        }

        $unidad = $this->dispatch(new BorrarUnidad($unidad, $request->user('api')));

        return $this->validSuccessJsonResponse('Success');
    }
}
