<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\{ DistribuirExpensas };
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class DistribuirExpensasController extends Controller
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
            'criterio_distribucion' => 'required',
            'nro_comprobante' => 'required',
            'fecha_vencimiento' => 'required',
            'unidades' => 'required',
            'enum_estado' => 'required',
            'id_inmueble_padre' => 'required',
            ]
        );

       
       

        $retorno = $this->dispatchNow(new DistribuirExpensas($request, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}