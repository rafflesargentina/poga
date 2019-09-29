<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Pagare };

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RechazarPagoSolicitud
{
    use DispatchesJobs,AuthorizesRequests;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user, $pagare;

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

        $pagare = Pagare::findOrFail($this->data['id_pagare'])->first();
        
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
        $this->authorize('update', $this->pagare);
        
        $retorno = $this->rechazarPago();

        return $retorno;
    }

    public function rechazarPago(){

        $isUnicoPropietario = true;
        $isInmueble = true;        

        $idPropietario = $this->pagare->idInmueble->idPropietarioReferente()->first()->id;
        $idAdministrador = $this->pagare->idInmueble->idAdministradorReferente()->first()->id;       

        if($this->user->id == $idAdministrador ){
            $this->actualizarEstadoPago("PENDIENTE");
        }       

        return $this->pagare;

    }

    

    public function actualizarEstadoPago($estado){
        $this->pagare->enum_estado = $estado;
        $this->pagare->save();
        
        
    }




}