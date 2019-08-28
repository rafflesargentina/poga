<?php

namespace Raffles\Modules\Poga\Http\Controllers\Mantenimientos;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\{ CrearPagoMantenimiento };
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
            'id_mantenimiento' => 'required',
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'clasificacion_pagare' => 'required'
            ]
        );

        $retorno = $this->dispatch(new CrearPagoMantenimiento($request, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}