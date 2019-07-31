<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class SinAgendarInmuebleController extends Controller
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
            'fechaInicio' => 'required',
            'fechaFin' => 'required',
            'filtroPorEstado' => 'in:PENDIENTE,REALIZADO,NO_REALIZADO,INACTIVO,CONFIRMADO,RECHAZADO',
            'idInmueblePadre' => 'required',
            ]
        );

        $url = $this->getBaseUrl()."solicitudes/inmueble/sinAgendar";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');

        $response = $client->request(
            'GET', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => $request->all()
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return $this->validSuccessJsonResponse($data['ok'], $data['response']['list']);
    }
}
