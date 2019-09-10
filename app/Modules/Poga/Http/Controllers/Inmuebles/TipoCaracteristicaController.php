<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\TipoCaracteristicaRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class TipoCaracteristicaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new TipoCaracteristicaController instance.
     *
     * @return void
     */
    public function __construct(TipoCaracteristicaRepository $repository)
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
        $this->validate($request, [
            'idTipoInmueble' => 'required',
        ]);

        $items = $this->repository->with(['caracteristicas' => function($query) use($request) { return $query->where('enum_estado', 'ACTIVO')->where('id_tipo_inmueble', $request->idTipoInmueble); }])->where('enum_estado', 'ACTIVO')->get();

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
