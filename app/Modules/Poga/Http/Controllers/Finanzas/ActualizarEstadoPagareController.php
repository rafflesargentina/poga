<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Raffles\Modules\Poga\UseCases\{ ActualizarEstadoPagare };

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CambiarEstadoPagareController extends Controller
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
     * The PagareRepository object.
     *
     * @var PagareRepository $pagare
     */
    protected $repository;

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

        $pagare = $this->dispatchNow(new ActualizarEstadoPagare($data, $user));
        
        return $this->validSuccessJsonResponse('Success', $pagare);

    }
}
