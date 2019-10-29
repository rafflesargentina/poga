<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\UseCases\ConfirmarPagoFinanzas;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class ConfirmarPagoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new ConfirmarPagoController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request The request object.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate(
            [
	    'idFactura.banco' => 'sometimes|required_if:enum_medio_pago,TRANSFERENCIA_BANCARIA',
            'idFactura.nro_operacion' => 'sometimes|required_if:enum_medio_pago,TRANSFERENCIA_BANCARIA',
	    'id_pagare' => 'required',
            'enum_origen_fondo' => 'sometimes|required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $pagare = $this->dispatchNow(new ConfirmarPagoFinanzas($data, $user));

        return $this->validSuccessJsonResponse('Success', $pagare);
    }
}
