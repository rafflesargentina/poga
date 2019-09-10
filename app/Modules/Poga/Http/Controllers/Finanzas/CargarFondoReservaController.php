<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CargarFondoReservaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePadreRepository object.
     *
     * @var InmueblePadreRepository $pagare
     */
    protected $repository;

    /**
     * Create a new CargarFondoReservaController instance.
     *
     * @param InmueblePadreRepository $repository The InmueblePadreRepository object.
     *
     * @return void
     */
    public function __construct(InmueblePadreRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request The request object.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        //
    }
}
