<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\EspacioRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarEspacio, BorrarEspacio, CrearEspacio };
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class EspacioController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UnidadController instance.
     *
     * @param EspacioRepository $repository
     *
     * @return void
     */
    public function __construct(EspacioRepository $repository)
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

        $items = $this->repository->findEspacios($request->idInmueblePadre);
        return $this->validSuccessJsonResponse('Success', $items);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->find($id);

        if (!$model) {
            abort(404);
        }

        return $this->validSuccessJsonResponse('Success', $model);
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
                'nombre' => 'required',
                
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $espacio = $this->dispatch(new CrearEspacio($data, $user));

        return $this->validSuccessJsonResponse('Success', $espacio);
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
                'nombre' => 'required',

            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $espacio = $this->dispatch(new ActualizarEspacio($id, $data, $user));

        return $this->validSuccessJsonResponse('Success', $espacio);
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
        $espacio = $this->repository->find($id);

        if (!$espacio) {
            abort(404);
        }

        $data = $request->all();
        $user = $request->user('api');
        $espacio = $this->dispatch(new BorrarEspacio($espacio, $user));

        return $this->validSuccessJsonResponse('Success');
    }
}
