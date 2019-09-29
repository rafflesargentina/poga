<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Pagare;

use Illuminate\Foundation\Bus\DispatchesJobs;

class RechazarPagoFinanzas
{
    use DispatchesJobs;

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
    public function __construct($data, $user)
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
        $retorno = $this->rechazarPago();

        return $retorno;
    }

    protected function rechazarPago()
    {
        $idAdministrador = $this->pagare->idInmueble->idAdministradorReferente->id;       

        if($this->user->id == $idAdministrador ){
            $this->actualizarEstadoPago("PENDIENTE");
        }       

        return $this->pagare;
    }   

    protected function actualizarEstadoPago($estado){
        $this->pagare->enum_estado = $estado;
        $this->pagare->save();
    }
}
