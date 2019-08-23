<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CargarFondoReservaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Get the account for the authenticated user.
     *
     * @param Request $request The request object.
     *
     * @return \Illuminate\Http\JsonResponse
     */


      /**
     * The InmueblePadreRepository object.
     *
     * @var InmueblePadreRepository $pagare
     */
    protected $repository;

    public function __construct(InmueblePadreRepository $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(Request $request)
    {
       
       

    }
}
