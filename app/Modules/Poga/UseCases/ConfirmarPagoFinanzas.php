<?php

namespace Raffles\Modules\Poga\UseCases;


use Raffles\Modules\Poga\Models\{ Pagare, Inmueble, InmueblePadre };

use Illuminate\Foundation\Bus\DispatchesJobs;
use Carbon\Carbon;
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

    public function confirmarPago(){

        $isUnicoPropietario = true;
        $isInmueble = true;   

        $inmueble = Inmueble::findOrFail($this->pagare->id_inmueble);  

        $idPropietario = $inmueble->idPropietarioReferente()->first()->id;
        $idAdministrador = $inmueble->idAdministradorReferente()->first()->id;

        $propietarios =  $inmueble->propietarios()->get(); 
        

        if(count($propietarios) > 1){
            $isUnicoPropietario = false;
        }       

        if($inmueble->enum_tabla_hija == "UNIDADES")
            $isInmueble = false;       

        if($isUnicoPropietario){            

            if($this->user->id == $idPropietario){ 
                    
                if($this->pagare->idPersonaAcreedora()->first()->id == $idAdministrador){
                    $this->actualizarEstadoPago("A_CONFIRMAR_POR_ADMIN");
                }
                else{                 
                    $this->actualizarEstadoPago("PAGADO");
                }
            }

            if($this->user->id == $idAdministrador){ 
                
                if($this->pagare->id_persona_deudora !=  $idPropietario){
                    $this->actualizarEstadoPago("PAGADO");
                }
                else{

                    if($this->pagare->id_persona_deudora != $idPropietario){
                        $this->actualizarEstadoPago("PAGADO");
                    }
                    else{

                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            $this->actualizarEstadoDeudorPago("PAGADO",$idAdministrador);       
                            
                            $pagare = $inmueble->pagares()->create([
                                'id_administrador_referente' => $idAdministrador,
                                'id_persona_acreedora' => $idAdministrador,
                                'id_persona_deudora' =>  $idPropietario,
                                'monto' => $this->pagare->monto, 
                                'id_moneda' => $this->pagare->id_moneda,
                                'fecha_pagare' => Carbon::now(),                      
                                'enum_estado' =>"PENDIENTE",
                                'enum_clasificacion_pagare' => $this->pagare->enum_clasificacion_pagare
                            ]);                 
                        }
        
                        if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                            $this->actualizarEstadoPago("PAGADO");
                        }
                    }
                }          
            }
            else{
                if($this->user->id == $this->pagare->id_persona_deudora)
                    $this->actualizarEstadoPago("PAGADO");
            }
        }
        else{  //en condominio

            if($isInmueble){

                if($this->user->id == $idAdministrador){

                    if($this->pagare->enum_clasificacion_pagare == "EXPENSA"){

                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

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
            else{ //unidad

                if($this->user->id == $idPropietario){  
                    
                    if($this->pagare->idPersonaAcreedora()->first()->id == $idAdministrador){
                        $this->actualizarEstadoPago("A_CONFIRMAR_POR_ADMIN");
                    }
                    else{ //es el proveedor
                        $this->actualizarEstadoPago("PAGADO");
                    }                        
                }

                if($this->pagare->idPersonaAcreedora()->first()->id == $idInquilino){
                    if($this->user->id == $idInquilino)
                        $this->actualizarEstadoPago("PAGADO");
                }

                if($this->user->id == $idAdministrador){ 

                    if($this->pagare->id_persona_deudora == $idInquilino){
                        $this->actualizarEstadoPago("PAGADO");
                    }

                    if($this->pagare->id_persona_deudora == $idPropietario){

                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            if($this->pagare->id_persona_deudora == $idPropietario){
                                
                                $this->actualizarEstadoDeudorPago("PAGADO",$idAdministrador);
                                
                                $pagare = $inmueble->pagares()->create([
                                    'id_administrador_referente' => $idAdministrador,
                                    'id_persona_acreedora' => $idAdministrador,
                                    'id_persona_deudora' =>  $idPropietario,
                                    'monto' => $this->pagare->monto, 
                                    'id_moneda' => $this->pagare->id_moneda,
                                    'fecha_pagare' => Carbon::now(),                      
                                    'enum_estado' =>"PENDIENTE",
                                    'enum_clasificacion_pagare' => $this->pagare->enum_clasificacion_pagare 
                                ]); 
                            }                
                        }
    
                        if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                            $this->actualizarEstadoPago("PAGADO");
                        }
                    }
                }
            }       
        }
    }

    protected function descontarFondoReserva($cantidad){

        $monto =  $inmueble->idInmueblePadre()->first()->monto_fondo_reserva;
        $monto -= $cantidad;

        $inmueble_padre = InmueblePadre::findOrFail( $inmueble->idInmueblePadre()->first()->id);
        $inmueble_padre->monto_fondo_reserva = $monto;

        
        $inmueble_padre->save();

    }

    public function actualizarEstadoPago($estado){
        $this->pagare->update([
            'enum_estado' => $estado
        ]);
    }

    public function actualizarEstadoDeudorPago($estado,$id_persona){
        $this->pagare->update([
            'id_persona_deudora' =>  $id_persona,
            'enum_estado' => $estado
        ]);
    }




}