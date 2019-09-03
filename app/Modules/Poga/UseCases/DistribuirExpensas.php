<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Pagare, DistribucionExpensa };

use Illuminate\Foundation\Bus\DispatchesJobs;
use Carbon\Carbon;


class DistribuirExpensas
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

    public function handle()
    {    
       

        $distribucion = DistribucionExpensa::create([
            "fecha_distribucion" => Carbon::now(),
            "enum_estado" => "ACTIVO",
            "enum_criterio" => $this->data['criterio_distribucion'],
            "id_inmueble_padre" => $this->data['id_inmueble_padre']
        ]);

        foreach ($this->data['unidades'] as $unidadjson){

            $unidad = json_decode($unidadjson, true);    

        
            $inmueble_unidad = Inmueble::findOrFail($unidad['id']);
          
            if($inmueble_unidad->rentas()->first()->expensas){
                $deudor = $inmueble_unidad->idPropietarioReferente()->first()->id;
            }
            else{

                if($inmueble_unidad->idInquilinoReferente()->first())
                    $deudor = $inmueble_unidad->idInquilinoReferente()->first()->id;
                else{
                    $deudor = $inmueble_unidad->idPropietarioReferente()->first()->id;
                }
            }

            $this->crearPagare(
                $distribucion,
                $inmueble_unidad,
                $inmueble_unidad->idAdministradorReferente()->first()->id,
                $deudor,
                $unidad['monto']                   
            );
        } 

    }


    protected function crearPagare($distribucion,$inmueble,$acreedor, $deudor, $monto){

        $pagare = $inmueble->pagares()->create([
            'id_administrador_referente' =>  $inmueble->idAdministradorReferente()->first()->id,
            'id_persona_acreedora' => $acreedor,
            'id_persona_adeudora' =>  $deudor,
            'monto' => $monto, 
            'id_moneda' => $this->data['id_moneda'],
            'fecha_pagare' => Carbon::now(),        
            'fecha_vencimiento' => $this->data['fecha_vencimiento'],               
            'enum_estado' =>"PENDIENTE",
            'enum_clasificacion_pagare' => "DISTRIBUIDO_EXPENSA",
            'id_tabla' => $distribucion->id,            
            'pagado_con_fondos_de' => $this->data['enum_origen_fondos'],
            'nro_comprobante' => $this->data['nro_comprobante']
        ]);
    }

    




}