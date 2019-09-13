<?php

namespace Raffles\Modules\Poga\Http\Controllers\Rentas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\UseCases\FinalizarContratoRenta;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class FinalizarContratoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The RentaRepository object.
     *
     * @var RentaRepository
     */
    protected $repository;
    
    /**
     * Create a new FinalizarContratoController instance.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return void
     */
    public function __construct(RentaRepository $repository)
    {
        $this->middleware('auth:api');
    
        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request The request object.
     * @param int     $id      The Renta model id.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

	$request->validate([
            'fecha_finalizacion_contrato' => 'required|date',
	    'monto_descontado_garantia_finalizacion_contrato' => 'required|numeric',
	]);

        $data = $request->all();
        $user = $request->user('api');
        $renta = $this->dispatchNow(new FinalizarContratoRenta($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $renta);
    }
}
