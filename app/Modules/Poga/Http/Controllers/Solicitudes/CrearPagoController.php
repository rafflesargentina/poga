<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\{ CrearPagoSolicitud };
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CrearPagoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Get the account for the authenticated user.
     *
     * @param Request $request The request object.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        
        $user = $request->user('api');

        $this->validate(
            $request, [
            'id_solicitud' => 'required',
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'id_deudor' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'clasificacion_pagare' => 'required'
            ]
        );

        $retorno = $this->dispatch(new CrearPagoSolicitud($request, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}