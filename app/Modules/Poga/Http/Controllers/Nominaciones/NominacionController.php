<?php

namespace Raffles\Modules\Poga\Http\Controllers\Nominaciones;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\UseCases\CrearNominacionParaInmueble;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class NominacionController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The NominacionRepository.
     *
     * @var NominacionRepository
     */
    protected $repository;

    /**
     * Create a new NominacionController instance.
     *
     * @param NominacionRepository $repository The NominacionRepository.
     *
     * @return void
     */
    public function __construct(NominacionRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'idInmueblePadre' => 'required',
        ]);

        $items = $this->repository->findNominaciones($request->idInmueblePadre);

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inmueblePadre = $this->repository->findOrFail($request->id_inmueble_padre);

        $this->validate(
            $request, [
            'role_id' => [
                'required',
                Rule::unique('nominaciones')->where(
                    function ($query) use ($request, $inmueblePadre) {
                        $query->where('id_persona_nominada', $request->id_persona_nominada)
                            ->where('id_inmueble', $inmueblePadre->id_inmueble);
                    }
                ),
            ],
            'id_inmueble_padre' => 'required',
            ]
        );

        $data = [
            'enum_estado' => 'PENDIENTE',
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
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        $data = $request->all();
        $user = $request->user('api');
        //$nominacion = $this->dispatchNow(new BorrarRenta($model, $user));

        return $this->validSuccessJsonResponse('Success', $model);
    }
}
