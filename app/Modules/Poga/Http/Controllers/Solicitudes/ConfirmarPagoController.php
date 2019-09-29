<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\ConfirmarPagoSolicitud;
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
            'id_pagare' => 'required',
            'enum_origen_fondos' => 'required'
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new ConfirmarPagoSolicitud($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
