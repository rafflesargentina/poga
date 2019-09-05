<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\{ RechazarPagoSolicitud };
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RechazarPagoController extends Controller
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
        $this->validate(
            $request, [
            'id_pagare' => 'required',
            ]
        );

	$data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new RechazarPagoSolicitud($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);

        
    }
}
