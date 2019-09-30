<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\CrearPagoSolicitud;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CrearPagoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new CrearPagoController instance.
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
            'id_solicitud' => 'required',
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'id_persona_deudora' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'enum_clasificacion_pagare' => 'required'
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new CrearPagoSolicitud($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
