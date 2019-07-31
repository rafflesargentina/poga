<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmuebleRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RentaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmuebleRepository object.
     *
     * @var InmuebleRepository $inmueble
     */
    protected $repository;

    /**
     * Create a new PagoController instance.
     *
     * @param InmuebleRepository $repository The InmueblePadreRepository object.
     *
     * @return void
     */
    public function __construct(InmuebleRepository $repository)
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
        $this->validate(
            $request, [
            'idInmueblePadre' => 'required',
            ]
        );

        $inmueble = $this->repository->where('id_tabla_hija', $request->idInmueblePadre)->first();

        $items = $inmueble->rentas;

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
        $url = $this->getBaseUrl()."inmuebles/detalles";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');
        $response = $client->request(
            'GET', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => ['idPago' => $id]
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
        $inmueble = $this->repository->find($id);
        $inmueble->update($request->all());

        $idPago = $request->idPago;

        $inmueble->idPago->update(
            [
            'solicitud_directa_inquilinos' => $idPago['solicitudDirectaInquilinos']
            ]
        ); 

        return $this->validSuccessJsonResponse('Success', $inmueble->refresh());
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
