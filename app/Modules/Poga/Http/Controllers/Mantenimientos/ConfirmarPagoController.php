<?php

namespace Raffles\Modules\Poga\Http\Controllers\Mantenimientos;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\ConfirmarPagoMantenimiento;
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
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new ConfirmarPagoMantenimiento($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
