<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\SolicitudRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class SolicitudController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The SolicitudRepository object.
     *
     * @var SolicitudRepository $persona
     */
    protected $repository;

    /**
     * Create a new SolicitudController instance.
     *
     * @param  SolicitudRepository $repository The SolicitudRepository object.
     *
     * @return void
     */
    public function __construct(SolicitudRepository $repository)
    {
	$this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
	$request->validate([
            'idInmueblePadre' => 'required|numeric',
	]);

        $items = $this->repository->listar();

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
