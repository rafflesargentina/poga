<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class DashboardController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Where to redirect users after role selection.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __invoke(Request $request)
    {
        //$url = $this->getBaseUrl()."dashboard";
        //$client = $this->getHttpClient();
        $token = $request->header('Authorization');
        //$response = $client->request('GET', $url, [
            //'headers' => [
                //'x-li-format' => 'json',
                //'Authorization' => $token,
            //],
        //]);

        //$data = json_decode($response->getBody()->getContents(), true);

        $data = [];

        return $this->validSuccessJsonResponse('Success', $data, $this->redirectPath());
    }
}
