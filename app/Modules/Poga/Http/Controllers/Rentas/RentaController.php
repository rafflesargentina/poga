<?php

namespace Raffles\Modules\Poga\Http\Controllers\Rentas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\{ InmuebleRepository, RentaRepository };
use Raffles\Modules\Poga\UseCases\{ BorrarRenta, CrearRenta, ActualizarRenta };

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RentaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new RentaController instance.
     *
     * @param RentaRepository $repository
     *
     * @return void
     */
    public function __construct(RentaRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    { 
	$this->authorize('view', new $this->repository->model);

        $request->validate(
            [
            'idInmueblePadre' => 'required',
            ]
        );

	$user = $request->user('api');
        $items = $this->repository->findRentas();

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
	$model->loadMissing('idUnidad');

	$this->authorize('create', $model);

        return $this->validSuccessJsonResponse('Success', $model);
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
	$this->authorize('create', new $this->repository->model);

        $rInmueble = new InmuebleRepository;

        $request->validate(
            [
            'comision_administrador' => 'required|numeric',
            'dia_mes_pago' => 'required|numeric|max:28',
            'dias_multa' => 'required_if:multa,1',                
            'expensas' => 'boolean',
            'fecha_fin'  => 'required|date',
            'fecha_inicio' => 'required|date',
            'garantia'  => 'required|numeric',
            'id_inmueble' => 'required|numeric',
	    'id_inquilino' => [
	        'required',
		'numeric',
		Rule::unique('rentas')->where(function($query) use($request) {
                    $query->where('id_inmueble', $request->id_unidad ?? $request->id_inmueble);
		    $query->whereIn('rentas.enum_estado', ['ACTIVO','PENDIENTE']);
		})
	    ],	    
	    'id_moneda' => 'required|numeric',
	    'id_unidad' => [
	        Rule::requiredIf(function() use($request, $rInmueble) {
		$inmueble = $rInmueble->findOrFail($request->id_inmueble);
		    return (bool) $inmueble->idInmueblePadre->divisible_en_unidades;
		})
	    ],
	    'monto' => 'numeric',
            'monto_descontado_garantia_finalizacion_contrato' => 'numeric',
            'monto_multa_dia' => 'required_if:multa,1|numeric',
            'multa'=> 'required|boolean',
            'prim_comision_administrador' => 'required|numeric',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $renta = $this->dispatchNow(new CrearRenta($data, $user));

        return $this->validSuccessJsonResponse('Success', $renta);
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
        $request->validate(
            [
            'comision_administrador' => 'required|numeric',
            'dias_multa' => 'required_if:multa,1',
            'monto_multa_dia' => 'required_if:multa,1|numeric',
            'multa'=> 'required|boolean',
            'prim_comision_administrador' => 'required|numeric',
            ]
        );

	$model = $this->repository->findOrFail($id);
        $this->authorize('update', $model);

        $data = array_only($request->all(), ['comision_administrador', 'dias_multa', 'monto_multa_dia', 'multa', 'prim_comision_administrador']);
	$user = $request->user('api');

        $renta = $this->dispatchNow(new ActualizarRenta($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $renta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        $data = $request->all();
        $user = $request->user('api');
        $renta = $this->dispatchNow(new BorrarRenta($model, $user));

        return $this->validSuccessJsonResponse('Success', $renta);
    }
}
