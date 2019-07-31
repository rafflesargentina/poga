<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class DesvincularController extends Controller
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
            'idInmueblePadre' => 'required',
            ]
        );

        $url = $this->getBaseUrl()."inmuebles/rechazarNominacion";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');

        $response = $client->request(
            'PUT', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => $request->all()
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return $this->validSuccessJsonResponse($data['ok'] ? 'Success' : 'Failed', $data['response']);
    }
}
