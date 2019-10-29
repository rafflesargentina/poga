<?php

namespace Raffles\Modules\Poga\Http\Controllers\Mantenimientos;

use Raffles\Http\Controllers\Controller;
use Raffles\Modules\Poga\Models\Mantenimiento;
use Raffles\Modules\Poga\Repositories\MantenimientoRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class MantenimientoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The MantenimientoRepository object.
     *
     * @var MantenimientoRepository
     */
    protected $repository;

    /**
     * Create a new MantenimientoController instance.
     *
     * @param MantenimientoRepository $repository The MantenimientoRepository object.
     *
     * @return void
     */
    public function __construct(MantenimientoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
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

	$items = $this->repository->findAll();

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
        $request->merge(['enum_estado' => 'ACTIVO']);

        $this->authorize('create', new Mantenimiento);

        $request->validate([
	    'descripcion' => 'required',
            'enum_dias_semana' => 'required_if:repetir,1|min:1,max:7',
	    'enum_se_repite' => 'required_if:repetir,1',
	    'fecha_hora_programado' => 'required|date',
	    'fecha_terminacion_repeticion' => 'required_if:repetir,1|date',
            'id_proveedor_servicio' => 'required|numeric',
            'id_moneda' => 'required|numeric',
	    'monto' => 'required|numeric',
	    'repetir_cada' => 'required_if:repetir,1|numeric',
        ]);

	$data = $request->all();
	$user = $request->user('api');
	$mantenimiento = $this->repository->create($data)[1];

        return $this->validSuccessJsonResponse('Success', $mantenimiento);
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

        $this->authorize('view', $model);

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

        $this->authorize('update', $model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->repository->findOrFail($id);

        $this->authorize('delete', $model);
    }
}
