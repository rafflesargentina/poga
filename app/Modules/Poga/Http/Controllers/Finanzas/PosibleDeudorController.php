<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class PosibleDeudorController extends Controller
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
            'maximoResultados' => 'required',
            'primeraFila' => 'required',
            ]
        );

        $url = $this->getBaseUrl()."finanzas/posiblesDeudores";
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

        return $this->validSuccessJsonResponse($data['ok'], array_key_exists('list', $data['response']) ? $data['response']['list'] : $data['response']);
    }
}
