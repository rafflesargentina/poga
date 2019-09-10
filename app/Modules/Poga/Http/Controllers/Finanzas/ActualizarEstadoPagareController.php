<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\PagareRepository;
use Raffles\Modules\Poga\UseCases\ActualizarEstadoPagare;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class ActualizarEstadoPagareController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The PagareRepository object.
     *
     * @var PagareRepository $pagare
     */
    protected $repository;

    /**
     * Create a new ActualizarEstadoPagareController instance.
     *
     * @param PagareRepository $repository The PagareRepository object.
     *
     * @return void
     */
    public function __construct(PagareRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $this->validate(
            $request, [
            'idPagare' => 'required',
            'enum_estado' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $pagare = $this->dispatchNow(new ActualizarEstadoPagare($data, $user));
        
        return $this->validSuccessJsonResponse('Success', $pagare);

    }
}
