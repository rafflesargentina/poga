<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\TipoInmuebleRepository;
use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class TipoInmuebleController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new TipoInmuebleController instance.
     *
     * @return void
     */
    public function __construct(TipoInmuebleRepository $repository)
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
            'enum_aplica_a' => 'required|in:INMUEBLES,UNIDADES',
            ]
        );

        $items = $this->repository->findWhere(['enum_estado' => 'ACTIVO', 'enum_aplica_a' => $request->enum_aplica_a]);

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
