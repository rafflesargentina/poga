<?php

namespace Raffles\Modules\Poga\UseCases;


use Raffles\Modules\Poga\Models\{ Pagare, Inmueble, InmueblePadre };

use Illuminate\Foundation\Bus\DispatchesJobs;
use Carbon\Carbon;
class ConfirmarPagoRenta
{
    use DispatchesJobs;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user;

    /**
     * Create a new job instance.
     *
     * @param array $data The form data.
     * @param User  $user The User model.
     *
     * @return void
     */
    public function __construct($data,$user)
    {
        $this->data = $data;
        $this->user = $user;

        $pagare = Pagare::findOrFail($this->data['id_pagare']);
        
        $this->pagare = $pagare;
    }

    /**
     * Execute the job.
     *
     * @param PagareRepository $rPagare The PagareRepository object.
     *
     * @return void
     */
    public function handle()
    {
        $renta = $this->confirmarPago();

        return $renta;
    }

    public function confirmarPago(){

        $isUnicoPropietario = true;
        $isInmueble = true;

        $inmueble = Inmueble::findOrFail($this->pagare->id_inmueble);  

        $idPropietario = $inmueble->idPropietarioReferente()->first()->id;
        $idAdministrador = $inmueble->idAdministradorReferente()->first()->id;
        $idInquilino = $inmueble->idInquilinoReferente()->first()->id;
        $propietarios =  $inmueble->propietarios()->get();
        
        

        if(count($propietarios) > 1){
            $isUnicoPropietario = false;
        }       

        if($inmueble->enum_tabla_hija == "UNIDADES")
            $isInmueble = false;     
            
        if($this->user->id == $idInquilino)
            $this->actualizarEstadoPago("A_CONFIRMAR_ADMIN");
        
        if($this->user->id == $idAdministrador)
            $this->actualizarEstadoPago("PAGADO");
    }

    public function actualizarEstadoPago($estado){
        $this->pagare->update([
            'enum_estado' => $estado
        ]);
    }

    public function actualizarEstadoDeudorPago($estado,$id_persona){
        $this->pagare->update([
            'id_persona_adeudora' =>  $id_persona,
            'enum_estado' => $estado
        ]);
    }




}