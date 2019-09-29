<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\ConfirmarPagoFinanzas;
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
        
        $this->validate(
            $request, [
            'id_pagare' => 'required',
            'enum_origen_fondos' => 'required'
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatchNow(new ConfirmarPagoFinanzas($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
