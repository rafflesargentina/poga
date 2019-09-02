<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\{ CrearPagoFinanzas };
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
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'id_persona_adeudora' => 'required',
            'id_persona_acreedora' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'descripcion' => 'required',
            'id_inmueble' => 'required'
            ]
        );

        $retorno = $this->dispatch(new CrearPagoFinanzas($request, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);

        
    }
}