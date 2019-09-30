<?php

namespace Raffles\Modules\Poga\UseCases;

use Carbon\Carbon;
use Raffles\Modules\Poga\Models\{ Solicitud, Inmueble };
use Raffles\Modules\Poga\Models\Pagare;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CrearPagoFinanzas
{
    use DispatchesJobs,AuthorizesRequests;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user, $inmueble, $pagaresGenerados;

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

        $this->inmueble = Inmueble::findOrFail( $this->data['id_inmueble']);  

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
       
        
        
        $this->authorize('create',new Pagare);

        $pagares = $this->crearPago();

        return $pagares;
    }

    /**
     *  @param PagareRepository $rPagare The PagareRepository object.
     */
   
    protected function crearPago()
    {
        $isInmueble = true;
        $isUnicoPropietario = true;          

        $Propietario = $this->inmueble->idPropietarioReferente()->first();         
        $Administrador = $this->inmueble->idAdministradorReferente()->first();
        $Inquilino = $this->inmueble->idInquilinoReferente()->first();

        if(count($this->inmueble->propietarios()->get()) > 1){
            $isUnicoPropietario = false;
        }

        if($this->inmueble->enum_tabla_hija == "UNIDADES")
            $isInmueble = false;                

        

        if($isInmueble){          
            
            if($isUnicoPropietario){   
                
               
               switch($this->data['enum_estado']){
                    
                    
                    case 'PENDIENTE': //unico dueño                  

                    
              
                        $this->crearPagare(
                            $this->data['id_persona_acreedora'],
                            $this->data['id_persona_adeudora'],
                            "PENDIENTE"
                        );                   
                    
                    break;
                    case 'PAGADO':  // unico dueño

                        if($this->data['id_persona_adeudora'] != $Propietario->id){
                            
                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $this->data['id_persona_adeudora'],
                                "PAGADO"
                            ); 
                        }
                        
                        else{
                            if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                              
                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Administrador->id,
                                    "PAGADO"
                                ); 

                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Propietario->id,
                                    "PENDIENTE"
                                ); 

                            }

                            if($this->data['enum_origen_fondos'] == "PROPIETARIO"){

                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Propietario->id,
                                    "PAGADO"
                                ); 

                            }
                        }
                            
                    break;
                }
            }
            else{  //en condominio

               
                switch($this->data['enum_estado']){
                    
                    case 'PENDIENTE': //en condmonio       

                        if($this->data['enum_clasificacion_pagare'] == "EXPENSA"){
                            $this->crearPagareExpensa($this->solicitud->id_proveedor_servicio);                           
                        }
                        else{
                           
                        }                                                    
                        
                    break;
                    case 'PAGADO':   //condmonio      
                        
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            if($this->data['enum_clasificacion_pagare'] == "EXPENSA"){            
                                $this->crearPagareExpensa($this->solicitud->id_proveedor_servicio);                     
                            }                            

                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $Administrador->id,
                                "PAGADO"
                            );  
                        }             
                        
                        else if($this->data['enum_origen_fondos'] == "RESERVAS"){

                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $Propietario->id, 
                                "PAGADO"
                            );                             
                            $this->descontarFondoReserva($this->data['monto']);
                        }   
                        else{
                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $Propietario->id,
                                "PAGADO"
                            );                             
                        }              
                    break;
                }
            }
        }
        else{ //Unidad


            if($isUnicoPropietario){

                switch($this->data['enum_estado']){
                    
                    case 'PENDIENTE':
                        
                        $this->crearPagare(
                            $this->data['id_persona_acreedora'],
                            $this->data['id_persona_adeudora'],
                            "PENDIENTE"
                        );                  
    
                    break;
                    case 'PAGADO':        
                    
                        if($this->data['id_persona_adeudora'] == $Inquilino->id){
                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $this->data['id_persona_adeudora'],
                                "PAGADO"
                            );   
                        }
    
                        if($this->data['id_persona_adeudora'] == $Propietario->id){                   
                                
                            if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){
                                
                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Administrador->id,
                                    "PAGADO"
                                );  
    
                                $this->crearPagare(
                                   $Administrador->id,
                                    $Propietario->id,
                                    "PENDIENTE"
                                );                 
    
                            }
                            else if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                                
                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Propietario->id,
                                    "PAGADO"
                                ); 
    
                            }
                            else{
                               
                            }
                        }
                       
                                           
                    break;
                }

            }
            else{ //en condominio  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

                $deudor = $this->data['id_persona_adeudora'];
                if($this->data['enum_clasificacion_pagare'] == "EXPENSA"){
                    if($Inquilino->id){
                        
                        if($this->inmueble->rentas()->expensas){
                            $deudor = $Propietario->id;
                        }
                        else{
                            $deudor = $Inquilino->id;
                        }
                    }
                    else{
                        $deudor = $Propietario->id;
                    }
                }
               
                
                switch($this->data['enum_estado']){
                    
                    case 'PENDIENTE':
                        
                        $this->crearPagare(
                            $this->data['id_persona_acreedora'],
                            $deudor,
                            "PENDIENTE"
                        );                  
    
                    break;
                    case 'PAGADO':        
                    
                        if($this->data['id_persona_adeudora'] == $Inquilino->id){
                            $this->crearPagare(
                                $this->data['id_persona_acreedora'],
                                $this->data['id_persona_adeudora'],
                                "PAGADO"
                            );   
                        }
    
                        if($this->data['id_persona_adeudora'] == $Propietario->id){                   
                                
                            if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){
                                
                               
                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Administrador->id,
                                    "PAGADO"
                                );  
    
                                $this->crearPagare(
                                   $Administrador->id,
                                    $Propietario->id,
                                    "PENDIENTE"
                                );                 
    
                            }
                            else if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                                
                               
                                $this->crearPagare(
                                    $this->data['id_persona_acreedora'],
                                    $Propietario->id,
                                    "PAGADO"
                                ); 
    
                            }
                            else{
                               
                            }
                        }
                       
                                           
                    break;
                }
            }
        }

        return $this->pagaresGenerados;
    }

    protected function descontarFondoReserva($cantidad){

        $monto = $this->inmueble->idInmueblePadre()->first()->monto_fondo_reserva;
        $monto -= $cantidad;

        $inmueble_padre = InmueblePadre::findOrFail($this->inmueble->idInmueblePadre()->first()->id);
        $inmueble_padre->monto_fondo_reserva = $monto;

        
        $inmueble_padre->save();

    }

    protected function crearPagareExpensa($deudor){

        $pagare = $this->inmueble->pagares()->create([
            'id_administrador_referente' => $this->inmueble->idAdministradorReferente()->first()->id,
            'id_persona_acreedora' => $this->data['id_persona_acreedora'],
            'id_persona_adeudora' => $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                  
            'enum_estado' => $this->data['enum_estado'],
            'enum_clasificacion_pagare' => "EXPENSA",
        ]);

        $this->pagaresGenerados[] = $pagare;
    } 

    protected function crearPagare($acreedor,$deudor,$estado){

        if($estado == "PENDIENTE"){
            $this->data['enum_origen_fondos'] = null;
        }
        
        $pagare = $this->inmueble->pagares()->create([
            'id_administrador_referente' =>  $this->inmueble->idAdministradorReferente()->first()->id,
            'id_persona_acreedora' => $acreedor,
            'id_persona_adeudora' => $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                          
            'enum_estado' => $estado,
            'enum_clasificacion_pagare' => $this->data['enum_clasificacion_pagare'],
            'pagado_con_fondos_de' => $this->data['enum_origen_fondos']
        ]);

        $this->pagaresGenerados[] = $pagare;
    }


}