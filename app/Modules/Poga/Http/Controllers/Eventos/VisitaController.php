<?php

namespace Raffles\Modules\Poga\Http\Controllers\Eventos;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\EventoRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarVisita, BorrarVisita, CrearVisita };

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class VisitaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UnidadController instance.
     *
     * @param EventoRepository $repository
     *
     * @return void
     */
    public function __construct(EventoRepository $repository)
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

        $items = $this->repository->findVisitas($request->idInmueblePadre);

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
        $this->validate($request, [
            'fecha_fin' => 'required|date',
            'fecha_inicio' => 'required|date',
            'hora_fin' => 'required|date_format:H:i',
            'hora_inicio' => 'required|date_format:H:i',
            'id_inmueble' => 'required',
            'invitados' => 'array',
            'nombre' => 'required',
        ]);

        $data = $request->all();
        $user = $request->user('api');
        $evento = $this->dispatch(new CrearVisita($data, $user));

        return $this->validSuccessJsonResponse('Success', $evento);
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

        $model->loadMissing('invitados');

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
            'fecha_fin' => 'required|date',
            'fecha_inicio' => 'required|date',
            'hora_fin' => 'required',
            'hora_inicio' => 'required',
            'invitados' => 'array',
            'nombre' => 'required',
        ]);

        $data = $request->all();
        $model = $this->repository->findOrFail($id);
        $user = $request->user('api');
        $evento = $this->dispatch(new ActualizarVisita($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $evento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        $model = $this->dispatch(new BorrarVisita($model, $request->user('api')));

        return $this->validSuccessJsonResponse('Success');
    }
}
