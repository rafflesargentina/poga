<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\UseCases\{ BorrarRenta, CrearRenta };
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RentaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UnidadController instance.
     *
     * @param RentaRepository $repository
     *
     * @return void
     */
    public function __construct(RentaRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate(
            $request, [
            'idInmueblePadre' => 'required',
            ]
        );

        $items = $this->repository->fetchRentas($request->idInmueblePadre);
        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      

        $this->validate(
            $request, [
                'comision_administrador'  => 'required|numeric',
                'dias_multa' => 'required_if:multa,1',                
                'expensas' => 'numeric',
                'fecha_fin'  => 'required|date',
                'fecha_finalizacion_contrato' => 'date',  //???
                'fecha_inicio' => 'required|date',
                'garantia'  => 'required|numeric',
                'id_inmueble' => 'required|numeric',
                'id_inquilino' => 'required|numeric',
                'id_moneda' => 'required|numeric',
                'monto' => 'numeric',
                'monto_descontado_garantia_finalizacion_contrato'=> 'numeric',
                'monto_multa_dia' => 'required_if:multa,1|numeric',
                'multa'=> 'required|numeric',
                'prim_comision_administrador'  => 'required|numeric',
                
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $renta = $this->dispatch(new CrearRenta($data, $user));


        return $this->validSuccessJsonResponse('Success', $renta);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Renta = $this->repository->find($id);

        if (!$Renta) {
            abort(404);
        }

        $data = $request->all();
        $user = $request->user('api');
        $renta = $this->dispatch(new BorrarRenta($Renta, $user));

        return $this->validSuccessJsonResponse('Success');
    }
}