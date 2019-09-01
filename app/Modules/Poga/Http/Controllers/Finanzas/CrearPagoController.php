<?php

namespace Raffles\Modules\Poga\Http\Controllers\Finanzas;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\PagareRepository;
use Raffles\Modules\Poga\UseCases\{ CrearPagare };
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class CrearPagoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmuebleRepository object.
     *
     * @var InmuebleRepository $inmueble
     */
    protected $repository;

    public function __construct(PagareRepository $repository)
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
        $user = $request->user('api');

        $this->validate(
            $request, [
            'enum_estado' => 'required',
            'id_moneda' => 'required',
            'id_persona_adeudora' => 'required',
            'id_persona_acreedora' => 'required',
            'monto' => 'required',
            'enum_origen_fondos' => 'required',
            'descripcion' => 'required'
            ]
        );

        $retorno = $this->dispatch(new CrearPagoSolicitud($request, $user));

        return $this->validSuccessJsonResponse('Success', $retorno);

    }

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        $pagare = $this->repository->find($id);
        $pagare->update($request->all());       

        return $this->validSuccessJsonResponse('Success',  $pagare);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
