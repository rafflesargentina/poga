<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\MedidaRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class MedidaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new MedidaController instance.
     *
     * @param MedidaRepository $repository
     *
     * @return void
     */
    public function __construct(MedidaRepository $repository)
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
        $items = $this->repository->findAll();

        return $this->validSuccessJsonResponse('Success', $items);
    }
}
