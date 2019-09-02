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
    protected $data, $user, $solicitud;

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

        $this->solicitud = Solicitud::findOrFail($this->data['id_solicitud']);

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
        
        $inmueble = Inmueble::findOrFail($this->solicitud->id_inmueble);  

        
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

                echo "OK";
                exit();
                
                switch($this->data['enum_estado']){
                    
                    case 'PENDIENTE': //unico dueño                  

                        $this->crearPagareSolicitud(
                            $this->solicitud->id_proveedor,
                            $this->data['id_adeudor'],
                            "PENDIENTE"
                        );                   
                    
                    break;
                    case 'PAGADO':  // unico dueño

                        if($this->data['id_deudor'] != $Propietario->id){
                            
                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
                                $this->data['id_adeudor'],
                                "PAGADO"
                            ); 
                        }
                        
                        else{
                            if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                              
                                $this->crearPagareSolicitud(
                                    $this->solicitud->id_proveedor,
                                    $Administrador->id,
                                    "PAGADO"
                                ); 

                                $this->crearPagareSolicitud(
                                    $Administrador->id,
                                    $Propietario->id,
                                    "PENDIENTE"
                                ); 

                            }

                            if($this->data['enum_origen_fondos'] == "PROPIETARIO"){

                                $this->crearPagareSolicitud(
                                    $this->solicitud->id_proveedor,
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

                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
                                $Administrador->id,
                                "PAGADO"
                            );  
                        }             
                        
                        else if($this->data['enum_origen_fondos'] == "RESERVAS"){

                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
                                $Propietario->id, //????? cual iria?
                                "PAGADO"
                            );                             
                            //Aca discminuir el fondo de reserva
                        }   
                        else{
                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
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
                    
                    $this->crearPagareSolicitud(
                        $this->solicitud->id_proveedor,
                        $this->data['id_deudor'],
                        "PENDIENTE"
                    );                  

                break;
                case 'PAGADO':        
                
                    if($this->data['id_deudor'] == $Inquilino->id){
                        $this->crearPagareSolicitud(
                            $this->solicitud->id_proveedor,
                            $this->data['id_deudor'],
                            "PAGADO"
                        );   
                    }

                    if($this->data['id_deudor'] == $Propietario->id){                   
                            
                        if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){
                            
                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
                                $Administrador->id,
                                "PAGADO"
                            );  

                            $this->crearPagareSolicitud(
                                $Administrador->id,
                                $Propietario->id,
                                "PENDIENTE"
                            );                 

                        }
                        else if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                            
                            $this->crearPagareSolicitud(
                                $this->solicitud->id_proveedor,
                                $Propietario->id,
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

    protected function crearPagareExpensa($acreedor){

        $pagare = $inmueble->pagares()->create([
            'id_administrador_referente' => $Administrador->id,
            'id_persona_adeudora' => $this->data['id_deudor'],
            'id_persona_acreedora' => $acreedor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => "EXPENSA",
            'id_tabla' => $this->solicitud->id,
        ]);
    } 

    protected function crearPagareSolicitud($acreedor, $deudor, $estado){

        $pagare = $inmueble->pagares()->create([
            'id_administrador_referente' =>  $Administrador->id,
            'id_persona_acreedora' => $acreedor,
            'id_persona_adeudora' =>  $deudor,
            'monto' => $this->data['monto'], 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),                      
            'enum_estado' =>$estado,
            'enum_clasificacion_pagare' => "SOLICITUD",
            'id_tabla' => $this->solicitud->id,            
            'pagado_con_fondos_de' => $this->data['enum_origen_fondos']
        ]);
    }


}