<?php

namespace Raffles\Modules\Poga\UseCases;

use Carbon\Carbon;
use Raffles\Modules\Poga\Models\{ Mantenimiento, Inmueble, InmueblePadre };


use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearPagoMantenimiento
{
    use DispatchesJobs;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user, $mantenimiento;

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

        $this->mantenimiento = Mantenimiento::findOrFail($this->data['id_mantenimiento']);

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
        $renta = $this->crearPago();

        return $renta;
    }

    /**
     *  @param PagareRepository $rPagare The PagareRepository object.
     */
   
    protected function crearPago()
    {
        $isInmueble = true;
        $isUnicoPropietario = true;      
        
        $inmueble = Inmueble::findOrFail($this->mantenimiento->id_inmueble);  

        $Propietario = $inmueble->idPropietarioReferente()->first();
        $Administrador = $inmueble->idAdministradorReferente()->first();
        $Inquilino = $inmueble->idInquilinoReferente()->first();    

        
        

        if(count($inmueble->propietarios()->get()) > 1){
            $isUnicoPropietario = false;
        }

        if($inmueble->enum_tabla_hija == "UNIDADES")
            $isInmueble = false;        
            
         

        if($isInmueble){
            
            if($isUnicoPropietario){          
               
                switch($this->data['enum_estado']){
                    
                    
                    case 'PENDIENTE': //unico dueño


                        $this->crearPagareMantenimiento(
                            $this->mantenimiento->id_proveedor_servicio,
                            $Propietario->id,
                            "PENDIENTE"
                        );                   
                    
                    break;
                    case 'PAGADO':  // unico dueño
                    
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            $this->crearPagareMantenimiento(
                                $this->mantenimiento->id_proveedor_servicio,
                                $Administrador->id,
                                "PAGADO"
                            ); 

                            $this->crearPagareMantenimiento(
                                $Administrador->id,
                                $Propietario->id,
                                "PENDIENTE"
                            ); 

                        }

                        if($this->data['enum_origen_fondos'] == "PROPIETARIO"){

                            $this->crearPagareMantenimiento(
                                $this->mantenimiento->id_proveedor_servicio,
                                $Propietario->id,
                                "PAGADO"
                            ); 

                        }
                            
                    break;
                }
            }
            else{  //en condominio

               
                switch($this->data['enum_estado']){
                    
                    case 'PENDIENTE': //en condmonio       

                        if($this->data['enum_clasificacion_pagare'] == "EXPENSA"){
                            $this->crearPagareExpensa($this->mantenimiento->id_proveedor_servicio);                           
                        }
                        else{
                            //ERROR!
                        }                                                    
                        
                    break;
                    case 'PAGADO':   //condmonio      
                        
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            if($this->data['enum_clasificacion_pagare'] == "EXPENSA"){            
                                $this->crearPagareExpensa($this->mantenimiento->id_proveedor_servicio);                     
                            }                            

                            $this->crearPagareMantenimiento(
                                $this->mantenimiento->id_proveedor_servicio,
                                $Administrador->id,
                                "PAGADO"
                            );  
                        }             
                        
                        else if($this->data['enum_origen_fondos'] == "RESERVAS"){

                            $this->crearPagareMantenimiento(
                                $this->mantenimiento->id_proveedor_servicio,
                                $Propietario->id, 
                                "PAGADO"
                            );    
                            
                            $this->descontarFondoReserva($this->data['monto']);
                        }   
                        else{
                            $this->crearPagareMantenimiento(
                                $this->mantenimiento->id_proveedor_servicio,
                                $Propietario->id,
                                "PAGADO"
                            );                             
                        }              
                    break;
                }
            }
        }
        else{ //Unidad

            switch($this->data['enum_estado']){
                    
                case 'PENDIENTE':
                    //base
                    $this->crearPagareMantenimiento(
                        $this->mantenimiento->id_proveedor_servicio,
                        $Propietario->id,
                        "PENDIENTE"
                    );                  

                break;
                case 'PAGADO':                        
                        
                    if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){
                        
                        $this->crearPagareMantenimiento(
                            $this->mantenimiento->id_proveedor_servicio,
                            $Administrador->id,
                            "PAGADO"
                        );  

                        $this->crearPagareMantenimiento(
                            $Administrador->id,
                            $Propietario->id,
                            "PENDIENTE"
                        );                 

                    }
                    else if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                        
                        $this->crearPagareMantenimiento(
                            $this->mantenimiento->id_proveedor_servicio,
                            $Propietario->id,
                            "PAGADO"
                        ); 

                    }
                    else{
                        //ERROR!
                    }
                   
                                       
                break;
            }
           
            
        }




       

            //Proovedor es el acreedor
           
        
    }

    protected function descontarFondoReserva($cantidad){

        $monto = $this->mantenimiento->idInmueble->idInmueblePadre()->first()->monto_fondo_reserva;
        $monto -= $cantidad;

        $inmueble_padre = InmueblePadre::findOrFail($this->mantenimiento->idInmueble->idInmueblePadre()->first()->id);
        $inmueble_padre->monto_fondo_reserva = $monto;

        
        $inmueble_padre->save();


    }

    protected function crearPagareExpensa($acreedor){

        $pagare = $this->mantenimiento->idInmueble->pagares()->create([
            'id_administrador_referente' => $this->mantenimiento->idInmueble->idAdministradorReferente()->first()->id,
            'id_persona_acreedora' => $acreedor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => "EXPENSA",
            'id_tabla' => $this->mantenimiento->id,
           
        ]);
    } 

    protected function crearPagareMantenimiento($acreedor, $deudor, $estado){

        $pagare = $this->mantenimiento->idInmueble->pagares()->create([
            'id_administrador_referente' =>  $this->mantenimiento->idInmueble->idAdministradorReferente()->first()->id,
            'id_persona_acreedora' => $acreedor,
            'id_persona_deudora' =>  $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                      
            'enum_estado' =>$estado,
            'enum_clasificacion_pagare' => "MANTENIMIENTO",
            'id_tabla' => $this->mantenimiento->id,            
            'pagado_con_fondos_de' => $this->data['enum_origen_fondos'],
            
        ]);
    }


}