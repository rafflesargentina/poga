<?php

namespace Raffles\Modules\Poga\Http\Controllers\Nominaciones;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\NominacionRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RechazarController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The NominacionRepository object.
     *
     * @var NominacionRepository
     */
    protected $repository;

    /**
     * Create a new RechazarController instance.
     *
     * @param  NominacionRepository $repository
     *
     * @return void
     */
    public function __construct(NominacionRepository $repository)
    {
        $this->middleware('auth:api');
    
        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request The request object.
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
	$model = $this->repository->findOrFail($id);

	$nominacion = $this->repository->update($model, ['enum_estado' => 'RECHAZADO']);

        return $this->validSuccessJsonResponse('Success', $nominacion);
    }
}
