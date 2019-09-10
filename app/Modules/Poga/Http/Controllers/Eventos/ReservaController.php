<?php

namespace Raffles\Modules\Poga\Http\Controllers\Eventos;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\EventoRepository;
use Raffles\Modules\Poga\UseCases\CrearReserva;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class ReservaController extends Controller
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

        $items = $this->repository->findReservas($request->idInmueblePadre);

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
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'hora_inicio' => 'required|date_format:H:i|before:hora_fin',
            'id_espacio' => 'required',
            'id_inmueble' => 'required',
            'invitados' => 'array',
            'nombre' => 'required',
        ]);

        $data = $request->all();
        $user = $request->user('api');
        $evento = $this->dispatch(new CrearReserva($data, $user));

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
