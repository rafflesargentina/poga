<?php

namespace Raffles\Modules\Poga\UseCases;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Models\Inmueble;
use Raffles\Modules\Poga\Models\Pagare;

class GenerarPagares implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rRenta;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RentaRepository $rRenta)
    {
        //
        $this->rRenta = $rRenta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
       $this->generarRentas();
      // $this->generarComisionRenta();
    }

    protected function generarRentas(){
        $rentas = $this->rRenta->where('enum_estado', 'ACTIVO')->get();   
        

        foreach($rentas as $renta) {
            $this->generarPagoRenta($renta);
            $this->generarPagoConserje($renta);
            $this->generarPagoAdministrador($renta);
        }
    }

   

    public function generarPagoRenta(Renta $renta ){
        $now = $now = Carbon::now()->startOfDay();              
            $fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
            $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);
            
            if($now->eq($fechaCreacionPagare)){

                $inmueble = Inmueble::find($renta->id_inmueble); 
                $pagare = $inmueble->pagares()->create([
                    'id_persona_acreedora' => $renta->idInmueble->idPropietarioReferente()->first()->id,
                    'id_persona_adeudora' => $renta->id_inquilino,
                    'monto' => $renta->monto,
                    'id_moneda' => $renta->id_moneda,
                    'fecha_pagare' => $fechaCreacionPagare,                      
                    'enum_estado' => 'PENDIENTE',
                    'enum_clasificacion_pagare' => 'RENTA',
                    'id_tabla_hija' => $renta->id,
                ]);              

            }
    }

    protected function generarComisionRenta(Renta $renta){       // $rentas = $this->rRenta->where('enum_estado', 'ACTIVO')->get(); 
   
        $now = $now = Carbon::now()->startOfDay();              
        $comision = $renta->monto * $renta->prim_comision_administrador / 100;
        //Si está pasado el proporcional de los dias del mes

        $inmueble = Inmueble::find($renta->id_inmueble); 
        $pagare = $inmueble->pagares()->create([
            'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente()->first()->id,
            'id_persona_adeudora' => $renta->idInmueble->idPropietarioReferente()->first()->id,
            'monto' => $comision, 
            'id_moneda' => $renta->id_moneda,
            'fecha_pagare' => $fechaCreacionPagare,                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => 'COMISION_RENTA_ADMIN',
            'id_tabla_hija' => $renta->id,
        ]);       

    }

    public function generarPagoConserje(Renta $renta){

        $now = $now = Carbon::now()->startOfDay();              
        $fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
        $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);

        $pagare = $inmueble->pagares()->create([
            'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente()->first()->id,
            'monto' => $comision, 
            'id_moneda' => $renta->id_moneda,
            'fecha_pagare' => $fechaCreacionPagare,                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => 'SALARIO_CONSERJE',
            'id_tabla_hija' => $renta->id,
        ]);     

    }

    public function generarPagoAdministrador(){

        $now = $now = Carbon::now()->startOfDay();              
        $fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
        $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);

        $pagare = $inmueble->pagares()->create([
            'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente()->first()->id,
            'monto' => $comision, 
            'id_moneda' => $renta->id_moneda,
            'fecha_pagare' => $fechaCreacionPagare,                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => 'SALARIO_ADMINISTRADOR',
            'id_tabla_hija' => $renta->id,
        ]);
    }
}
