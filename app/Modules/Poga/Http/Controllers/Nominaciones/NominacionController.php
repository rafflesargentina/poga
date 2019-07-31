<?php

namespace Raffles\Modules\Poga\Http\Controllers\Nominaciones;

use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;
use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\UseCases\CrearNominacionParaInmueble;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class NominacionController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePadreRepository.
     *
     * @var InmueblePadreRepository $repository
     */
    protected $repository;

    /**
     * Create a new NominacionController instance.
     *
     * @param InmueblePadreRepository $repository The InmueblePadreRepository.
     *
     * @return void
     */
    public function __construct(InmueblePadreRepository $repository)
    {
        $this->middleware('auth:api');

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

        $model = $this->repository->find($request->idInmueblePadre);

        $model->loadMissing('idInmueble.nominaciones');

        $items = $model->idInmueble->nominaciones;

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
        $inmueblePadre = $this->repository->find($request->id_inmueble_padre);

        $this->validate($request, [
            'role_id' => [
                'required',
                Rule::unique('nominaciones')->where(function($query) use($request, $inmueblePadre) {
                    return $query->where('id_persona_nominada', $request->id_persona_nominada)
                                 ->where('id_inmueble', $inmueblePadre->id_inmueble);
                }),
            ],
            'id_inmueble_padre' => 'required',
        ]);

        $data = [
            'enum_estado' => 'EN_CURSO',
            'role_id' => $request->role_id,
            'id_persona_nominada' => $request->id_persona_nominada,
            'id_usuario_principal' => $request->id_usuario_principal ?: $request->user('api')->id,
            'id_inmueble' => $inmueblePadre->id_inmueble,
            'usu_alta' => $request->usu_alta ?: $request->user()->id
        ];

        $nominacion = $this->dispatch(new CrearNominacionParaInmueble($data));

        return $this->validSuccessJsonResponse('Success', $nominacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $url = $this->getBaseUrl()."nominaciones/detalles";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');
        $response = $client->request(
            'GET', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => ['idNominacion' => $id]
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
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $url = $this->getBaseUrl()."nominaciones";
        $client = $this->getHttpClient();
        $token = $request->header('Authorization');
        $response = $client->request(
            'DELETE', $url, [
            'headers' => [
                'x-li-format' => 'json',
                'Authorization' => $token,
            ],
            'query' => ['idNominacion' => $id]
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return $this->validSuccessJsonResponse($data['ok'] ? 'Success' : 'Failed', $data['response']);
    }
}
