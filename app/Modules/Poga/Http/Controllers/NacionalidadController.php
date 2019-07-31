<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class NacionalidadController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = $this->getBaseUrl()."acceso/login";
        $client = $this->getHttpClient();
        $response = $client->request(
            'GET', $url, [
            'query' => ['correo' => 'eladministrador@gmail.com', 'password' => 'admin123']
            ]
        );
        $token = "Bearer ".json_decode($response->getBody()->getContents(), true)['response']['token'];

        $url = $this->getBaseUrl()."acceso/nacionalidades";
        $client = $this->getHttpClient();
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

        return $this->validSuccessJsonResponse($data['ok'], $data['response']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
