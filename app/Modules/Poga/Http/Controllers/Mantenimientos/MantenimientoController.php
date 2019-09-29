<?php

namespace Raffles\Modules\Poga\Http\Controllers\Mantenimientos;

use Raffles\Modules\Poga\Repositories\{ MantenimientoRepository, ProveedorServicioRepository };
use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class MantenimientoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The MantenimientoRepository object.
     *
     * @var MantenimientoRepository $repository
     */
    protected $repository;

    /**
     * Create a new MantenimientoController instance.
     *
     * @param MantenimientoRepository     $repository         The MantenimientoRepository object.
     * @param ProveedorServicioRepository $rProveedorServicio The ProveedorServicioRepository object.
     *
     * @return void
     */
    public function __construct(MantenimientoRepository $repository, ProveedorServicioRepository $rProveedorServicio)
    {
        $this->repository = $repository;
        $this->rProveedorServicio = $rProveedorServicio;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $request->validate(
            [
            'idInmueblePadre' => 'required',
            ]
        );

        $items = $this->rProveedorServicio->findMantenimientos($request->idInmueblePadre);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

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
