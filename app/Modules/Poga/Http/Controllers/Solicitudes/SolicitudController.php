<?php

namespace Raffles\Modules\Poga\Http\Controllers\Solicitudes;

use Raffles\Modules\Poga\Repositories\SolicitudRepository;
use Raffles\Modules\Poga\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class SolicitudController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The SolicitudRepository object.
     *
     * @var SolicitudRepository $repository
     */
    protected $repository;

    /**
     * Create a new SolicitudController instance.
     *
     * @param SolicitudRepository $repository The SolicutudRepository object.
     *
     * @return void
     */
    public function __construct(SolicitudRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = $this->repository->findWhere(['id_inmueble_padre' => $request->idInmueblePadre]);

        return $this->validSuccessJsonResponse('Success', $items);
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
        $url = $this->getBaseUrl()."solicitudes/detalles";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');
        $response = $client->request(
            'GET', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => ['idSolicitud' => $id]
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return $this->validSuccessJsonResponse($data['ok'] ? 'Success' : 'Failed', $data['response']);
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
        $url = $this->getBaseUrl()."solicitudes";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');
        $response = $client->request(
            'DELETE', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => ['idSolicitud' => $id]
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return $this->validSuccessJsonResponse($data['ok'] ? 'Success' : 'Failed', $data['response']);
    }
}
