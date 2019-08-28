<?php

namespace Raffles\Modules\Poga\UseCases;


use Raffles\Modules\Poga\Models\{ Pagare, Inmueble };

use Illuminate\Foundation\Bus\DispatchesJobs;

class ConfirmarPagoMantenimiento
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

        $idPropietario = $this->pagare->idInmueble->idPropietarioReferente()->first()->id;
        $idAdministrador = $this->pagare->idInmueble->idAdministradorReferente()->first()->id;

        
        $inmueble = Inmueble::findOrFail($this->pagare->id_inmueble);  

        $propietarios =  $this->pagare->idInmueble->propietarios()->get();
        
        

        if(count($propietarios) > 1){
            $isUnicoPropietario = false;
        }       

        if($this->pagare->idInmueble->enum_tabla_hija == "UNIDAD")
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

                if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                    $this->actualizarEstadoPago("PAGADO");

                    
                    $pagare = $mantenimiento->idInmueble->pagares()->create([
                        'id_administrador_referente' => $this->mantenimiento->idInmueble->idAdministradorReferente()->first()->id,
                        'id_persona_acreedora' => $idAdministrador,
                        'id_persona_adeudora' =>  $idPropietario,
                        'monto' => $this->pagare->monto, 
                        'id_moneda' => $this->pagare->id_moneda,
                        'fecha_pagare' => Carbon::now(),                      
                        'enum_estado' =>"PENDIENTE",
                        'enum_clasificacion_pagare' => "MANTENIMIENTO" 
                    ]);                 
                }

                if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                    $this->actualizarEstadoPago("PAGADO");
                }

            }
        }
        else{  //en condominio

            if($isInmueble){

                if($this->pagare->clasificacion_pagare == "EXPENSA"){

                    $this->actualizarEstadoDeudorPago("PAGADO",$idAdministrador);

                    
                    $pagare = $mantenimiento->idInmueble->pagares()->create([
                        'id_administrador_referente' => $this->mantenimiento->idInmueble->idAdministradorReferente()->first()->id,
                        'id_persona_acreedora' => $idAdministrador,
                        'monto' =>$this->pagare->monto, 
                        'id_moneda' => $this->pagare->id_moneda,
                        'fecha_pagare' => Carbon::now(),                      
                        'enum_estado' =>"PENDIENTE",
                        'enum_clasificacion_pagare' => "EXPENSA",  
                    ]);
                    

                }
                else{ 

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

                if($this->user->id == $idAdministrador){ 

                    if($this->data['enum_origen_fondos'] == "ADMINISTRADOR"){

                        $this->actualizarEstadoDeudorPago("PAGADO",$idAdministrador);

                        $pagare = $mantenimiento->idInmueble->pagares()->create([
                            'id_administrador_referente' => $this->mantenimiento->idInmueble->idAdministradorReferente()->first()->id,
                            'id_persona_acreedora' => $idAdministrador,
                            'id_persona_adeudora' =>  $idPropietario,
                            'monto' => $this->pagare->monto, 
                            'id_moneda' => $this->pagare->id_moneda,
                            'fecha_pagare' => Carbon::now(),                      
                            'enum_estado' =>"PENDIENTE",
                            'enum_clasificacion_pagare' => "MANTENIMIENTO" 
                        ]);                 
                    }
    
                    if($this->data['enum_origen_fondos'] == "PROPIETARIO"){
                        $this->actualizarEstadoPago("PAGADO");
                    }
                }
            }
            

        }

    }

    

    public function actualizarEstadoPago($estado){
        $this->pagare->update([
            'enum_estado' => $estado
        ]);
    }

    public function actualizarEstadoDeudorPago($estado,$idAdministrador){
        $this->pagare->update([
            'id_persona_adeudora' =>  $idAdministrador,
            'enum_estado' => $estado
        ]);
    }




}