<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\MonedaRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class MonedaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new MonedaController instance.
     *
     * @param MonedaRepository $repository
     *
     * @return void
     */
    public function __construct(MonedaRepository $repository)
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
