<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Pagare, Inmueble, InmueblePadre };
use Raffles\Modules\Poga\Notifications\EstadoPagareActualizado;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ConfirmarPagoFinanzas
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

    public function confirmarPago()
    {
        $inmueble = Inmueble::findOrFail($this->pagare->id_inmueble);  

	$idAdministrador = $inmueble->idAdministradorReferente->id_persona;
	$idPropietario = $inmueble->idPropietarioReferente->id_persona;

	$unidad = $this->pagare->idUnidad;

	if ($unidad) {
	    $isUnicoPropietario = $unidad->idInmueblePadre->modalidad_propiedad !== 'EN_CONDOMINIO';
	} else {
            $isUnicoPropietario = $inmueble->idInmueblePadre->modalidad_propiedad !== 'EN_CONDOMINIO';
	}

	// Si es una Unidad o Inmueble en modalidad Único Propietario.
	if ($isUnicoPropietario) {
	    // Rol Propietario.
	    if($this->user->id_persona === $idPropietario) { 
                // Nuevo Pago (a estudiar).
		if($this->pagare->id_persona_acreedora === $idAdministrador) {
		    return $this->actualizarEstadoPago('A_CONFIRMAR_POR_ADMIN');

                // Pagare de Comisión de Renta Administrador.
		} elseif ($this->pagare->id_persona_acreedora === $idPropietario) {
                    return $this->actualizarEstadoPago('A_CONFIRMAR_POR_ADMIN');
		} else {                 
                    return $this->actualizarEstadoPago('PAGADO');
		}
            }

	    // Rol Administrador.
            if($this->user->id_persona === $idAdministrador){ 
                return $this->actualizarEstadoPago('PAGADO');
            }            

	    // Rol Inquilino.
	    if($this->user->id_persona === $this->pagare->id_persona_deudora) {
                if($this->pagare->id_persona_acreedora == $idAdministrador) {
	            $this->actualizarEstadoPago('A_CONFIRMAR_POR_ADMIN');

		// Si el acreedor es el propietario es un pagare de renta.
		} elseif($this->pagare->id_persona_acreedora == $idPropietario) {
                    $this->actualizarEstadoPago('A_CONFIRMAR_POR_ADMIN');
		} else {
                    $this->actualizarEstadoPago('PAGADO');
                }
	    }

	// Si es un Inmueble en modalidad Condominio (múltples propietarios).
	} else {
            // Rol Administrador.
            if ($this->user->id_persona === $idAdministrador) {

		// Expensas pagadas con fondos del administrador. 
	        if ($this->pagare->enum_clasificacion_pagare === "EXPENSA") {
                    if($this->data['enum_origen_fondos'] == "ADMINISTRADOR") {
                        $this->actualizarEstadoDeudorPago("PAGADO",$idAdministrador);

                        $pagare = $inmueble->pagares()->create([
                            'id_administrador_referente' => $idAdministrador,
                            'id_persona_acreedora' => $idAdministrador,
                            'id_persona_deudora' =>  $idPropietario,
                            'monto' => $this->pagare->monto,
                            'id_moneda' => $this->pagare->id_moneda,
                            'fecha_pagare' => Carbon::now(),
                            'enum_estado' =>"PENDIENTE",
                            'enum_clasificacion_pagare' => $this->pagare->enum_clasificacion_pagare,
                            'pagado_con_fondos_de' => "FONDO_ADMINISTRADOR"
                        ]);
                    }

                    if($this->data['enum_origen_fondos'] == "RESERVA"){
                        if($inmueble->idInmueblePadre()->first()->monto_fondo_reserva > $this->pagare->monto){
                            $this->descontarFondoReserva($this->pagare->monto);
                            $this->actualizarEstadoPago("PAGADO");
                        }
                    }
		}

                else{
                    $this->actualizarEstadoPago("PAGADO");
                }
            }
	}
    }

    protected function descontarFondoReserva($cantidad)
    {

        $monto =  $inmueble->idInmueblePadre()->first()->monto_fondo_reserva;
        $monto -= $cantidad;

        $inmueble_padre = InmueblePadre::findOrFail( $inmueble->idInmueblePadre->id);
        $inmueble_padre->monto_fondo_reserva = $monto;

        
        $inmueble_padre->save();

    }

    public function actualizarEstadoPago($estado)
    {
	$pagare = $this->pagare;

        $pagare->update([
            'enum_estado' => $estado
        ]);

        $administrador = $pagare->idInmueble->idAdministradorReferente->idPersona->user;
	$acreedor = $pagare->idPersonaAcreedora->user;
	$deudor = $pagare->idPersonaDeudora->user;

	$administrador->notify(new EstadoPagareActualizado($pagare));

	if ($acreedor) {
	    $acreedor->notify(new EstadoPagareActualizado($pagare));
	}
    
        if ($deudor) {
            $deudor->notify(new EstadoPagareActualizado($pagare));
	}
    
        return $pagare;
    }

    public function actualizarEstadoDeudorPago($estado,$id_persona){
        return $this->pagare->update([
            'id_persona_deudora' =>  $id_persona,
            'enum_estado' => $estado
        ]);
    }




}
