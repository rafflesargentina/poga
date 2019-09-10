<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\DistribuirExpensas;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class DistribuirExpensasController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new RechazarPagoController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request The request object.
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->validate(
            $request, [
            'criterio_distribucion' => 'required',
            'nro_comprobante' => 'required',
            'fecha_vencimiento' => 'required',
            'unidades' => 'required',
            'enum_estado' => 'required',
            'id_inmueble_padre' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatchNow(new DistribuirExpensas($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);
    }
}
