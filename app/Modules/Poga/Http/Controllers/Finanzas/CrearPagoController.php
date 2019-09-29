<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Raffles\Modules\Poga\UseCases\CrearPagoFinanzas;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CrearPagoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new CrearPagoController instance.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        
        
        $this->validate(
            $request, [
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'id_persona_adeudora' => 'required',
            'id_persona_acreedora' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'descripcion' => 'required',
            'id_inmueble' => 'required'
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $retorno = $this->dispatch(new CrearPagoFinanzas($data, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);

        
    }
}
