<?php

namespace Raffles\Modules\Poga\Http\Controllers\Mantenimientos;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\CrearPagoMantenimiento;
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
        $this->validate(
            $request, [
            'id_mantenimiento' => 'required',
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'enum_clasificacion_pagare' => 'required'
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new CrearPagoMantenimiento($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
