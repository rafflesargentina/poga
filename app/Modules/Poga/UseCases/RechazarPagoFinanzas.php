<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Pagare;
use Raffles\Modules\Poga\Notifications\EstadoPagareActualizado;

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
	$pagare = $this->pagare;
        $administrador = $this->pagare->idInmueble->idAdministradorReferente->idPersona->user;
	$acreedor = $pagare->idPersonaAcreedora->user;
	$deudor = $pagare->idPersonaDeudora->user;


	// Solo el administrador puede rechazar un pago.
        if ($this->user->id == $administrador->id) {
            $this->actualizarEstadoPago("PENDIENTE");
	
	    $administrador->notify(new EstadoPagareActualizado($pagare));

	    // El acreedor puede no tener usuario registrador.
	    if ($acreedor) {
                $acreedor->notify(new EstadoPagareActualizado($pagare));
	    }

            // El deudor puede no tener usuario registrador.
	    if ($deudor) {
                $deudor->notify(new EstadoPagareActualizado($pagare));
	    }
	}       

        return $this->pagare;
    }   

    protected function actualizarEstadoPago($estado){
        $this->pagare->enum_estado = $estado;
        $this->pagare->save();
    }
}
