<?php

namespace Raffles\Modules\Poga\UseCases;

use Carbon\Carbon;
use Raffles\Modules\Poga\Models\{ Solicitud, Inmueble };


use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearPagoSolicitud
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
        
        $inmueble = Inmueble::findOrFail( $this->data['id_inmueble']);  

        $idPropietario = $inmueble->idPropietarioReferente()->first()->id;
        $idAdministrador = $inmueble->idAdministradorReferente()->first()->id;
        $idInquilino = $inmueble->idInquilinoReferente()->first()->id;

        if(count($inmueble->propietarios()->get()) > 1){
            $isUnicoPropietario = false;
        }

        if($inmueble->enum_tabla_hija == "UNIDAD")
            $isInmueble = false;        
            
           

        if($isInmueble){
            
            if($isUnicoPropietario){            
               
               switch($this->data['enum_estado']){
                    
                    
                    case 'PENDIENTE': //unico dueño                  

                        $this->crearPagare(
                            $this->solicitud->id_proveedor,
                            $this->data['id_adeudor'],
                            "PENDIENTE"
                        );                   
                    
                    break;
                    case 'PAGADO':  // unico dueño

                        if($this->data['id_deudor'] != $idPropietario){
                            
                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $this->data['id_adeudor'],
                                "PAGADO"
                            ); 
                        }
                        
                        else{
                            if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                              
                                $this->crearPagare(
                                    $this->solicitud->id_proveedor,
                                    $idAdministrador,
                                    "PAGADO"
                                ); 

                                $this->crearPagare(
                                   $idAdministrador,
                                    $idPropietario,
                                    "PENDIENTE"
                                ); 

                            }

                            if($this->data['enum_origen_fondos'] == "PROPIETARIO"){

                                $this->crearPagare(
                                    $this->solicitud->id_proveedor,
                                    $idPropietario,
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

                        if($this->data['clasificacion_pagare'] == "EXPENSA"){
                            $this->crearPagareExpensa($this->solicitud->id_proveedor);                           
                        }
                        else{
                           
                        }                                                    
                        
                    break;
                    case 'PAGADO':   //condmonio      
                        
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                            if($this->data['clasificacion_pagare'] == "EXPENSA"){            
                                $this->crearPagareExpensa($this->solicitud->id_proveedor);                     
                            }                            

                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $idAdministrador,
                                "PAGADO"
                            );  
                        }             
                        
                        else if($this->data['enum_origen_fondos'] == "RESERVAS"){

                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $idPropietario, //????? cual iria?
                                "PAGADO"
                            );                             
                            //Aca discminuir el fondo de reserva
                        }   
                        else{
                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $idPropietario,
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
                    
                    $this->crearPagareMantenimiento(
                        $this->solicitud->id_proveedor,
                        $this->data['id_deudor'],
                        "PENDIENTE"
                    );                  

                break;
                case 'PAGADO':        
                
                    if($this->data['id_deudor'] == $idInquilino){
                        $this->crearPagareMantenimiento(
                            $this->solicitud->id_proveedor,
                            $this->data['id_deudor'],
                            "PAGADO"
                        );   
                    }

                    if($this->data['id_deudor'] == $idPropietario){                   
                            
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){
                            
                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $idAdministrador,
                                "PAGADO"
                            );  

                            $this->crearPagare(
                               $idAdministrador,
                                $idPropietario,
                                "PENDIENTE"
                            );                 

                        }
                        else if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                            
                            $this->crearPagare(
                                $this->solicitud->id_proveedor,
                                $idPropietario,
                                "PAGADO"
                            ); 

                        }
                        else{
                            //ERROR!
                        }
                    }
                   
                                       
                break;
            }
           
            
        }




       

            //Proovedor es el acreedor
           
        
    }

    protected function crearPagareExpensa($deudor){

        $pagare = $solicitud->idInmueble->pagares()->create([
            'id_administrador_referente' => $idAdministrador,
            'id_persona_acreedora' => $this->data['id_persona_acreedora'],
            'id_persona_adeudora' => $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => $this->data['fecha_pagare'],                      
            'enum_estado' => $this->data['enum_estado'],
            'enum_clasificacion_pagare' => "EXPENSA",
        ]);
    } 

    protected function crearPagare($deudor){

        $pagare = $this->solicitud->idInmueble->pagares()->create([
            'id_administrador_referente' =>  $idAdministrador,
            'id_persona_acreedora' => $this->data['id_persona_acreedora'],
            'id_persona_adeudora' => $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => $this->data['fecha_pagare'],                      
            'enum_estado' => $this->data['enum_estado'],
            'enum_clasificacion_pagare' => $this->data['enum_clasificacion_pagare'],
            'pagado_con_fondos_de' => $this->data['enum_origen_fondos']
        ]);
    }


}