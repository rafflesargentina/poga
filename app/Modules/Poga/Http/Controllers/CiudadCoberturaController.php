<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\CiudadRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CiudadCoberturaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new CiudadCoberturaController instance.
     *
     * @param CiudadRepository $repository The CiudadRepository object.
     *
     * @return void
     */
    public function __construct(CiudadRepository $repository)
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
        $request->validate(
            [
            'id_pais' => 'required'
            ]
        );

        $items = $this->repository->findWhere(['id_pais' => $request->id_pais]);

        //$url = $this->getBaseUrl()."acceso/login";
        //$client = $this->getHttpClient();
        //$response = $client->request('GET', $url, [
            //'query' => ['correo' => 'eladministrador@gmail.com', 'password' => 'admin123']
        //]);
        //$token = "Bearer ".json_decode($response->getBody()->getContents(), true)['response']['token'];
        //
        //$url = $this->getBaseUrl()."acceso/ciudadescobertura";
        //$client = $this->getHttpClient();
        //$response = $client->request('GET', $url, [
            //'headers' => [
                //'x-li-format' => 'json',
                //'Authorization' => $token,
            //],
            //'query' => $request->all()
        //]);

        //$data = json_decode($response->getBody()->getContents(), true);

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
