<?php

namespace Raffles\Modules\Poga\UseCases;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Models\{ Inmueble, Renta, Pagare };

class GenerarPagares implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rRenta;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $repository = new RentaRepository;
       $this->generarRentas($repository);
    }

    protected function generarRentas(RentaRepository $repository){
        $rentas = $repository->findWhere(['enum_estado' => 'ACTIVO']);

        foreach($rentas as $renta) {
            $this->generarPagoRenta($renta);
            //$this->generarPagoConserje($renta);
            //$this->generarPagoAdministrador($renta);
        }
    }

   

    public function generarPagoRenta(Renta $renta)
    {
        $now = Carbon::now()->subMonths(1);
        $fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
        $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);
            
	//if($now->eq($fechaCreacionPagare)){
	    $inmueble = $renta->idInmueble;
	    $pagare = $inmueble->pagares()->updateOrCreate(
            [
                'id_persona_acreedora' => $inmueble->idPropietarioReferente->id_persona,
                'id_persona_deudora' => $renta->id_inquilino,
                'fecha_pagare' => $fechaCreacionPagare,
                'enum_estado' => 'PENDIENTE',
                'enum_clasificacion_pagare' => 'RENTA',
                //'id_tabla' => $renta->id,
	    ],	    
	    [
                'id_persona_acreedora' => $inmueble->idPropietarioReferente->id_persona,
                'id_persona_deudora' => $renta->id_inquilino,
                'monto' => $renta->monto,
                'id_moneda' => $renta->id_moneda,
                'fecha_pagare' => $fechaCreacionPagare,                      
                'enum_estado' => 'PENDIENTE',
                'enum_clasificacion_pagare' => 'RENTA',
                'id_tabla' => $renta->id,
            ]);              
        //}
    }

    protected function generarComisionRenta(Renta $renta)
    {
   
        $now = Carbon::now()->startOfDay();              
        $comision = $renta->comision_administrador * $renta->monto / 100;
        //Si está pasado el proporcional de los dias del mes

        $pagare = $inmueble->pagares()->updateOrCreate([
            'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente->id_persona,
            'id_persona_deudora' => $renta->idInmueble->idPropietarioReferente->id_persona,
            'monto' => $comision, 
            'id_moneda' => $renta->id_moneda,
            'fecha_pagare' => $fechaCreacionPagare,                      
            'enum_estado' => 'PENDIENTE',
            'enum_clasificacion_pagare' => 'COMISION_RENTA_ADMIN',
            'id_tabla_hija' => $renta->id,
        ]);       
    }

    //public function generarPagoConserje(Renta $renta){

        //$now = $now = Carbon::now()->startOfDay();              
        //$fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
        //$fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);

        //$pagare = $inmueble->pagares()->create([
            //'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente()->first()->id,
            //'monto' => $comision, 
            //'id_moneda' => $renta->id_moneda,
            //'fecha_pagare' => $fechaCreacionPagare,                      
            //'enum_estado' => 'PENDIENTE',
            //'enum_clasificacion_pagare' => 'SALARIO_CONSERJE',
            //'id_tabla_hija' => $renta->id,
        //]);     

    //}

    //public function generarPagoAdministrador(Renta $renta)
    //{
        //$now = $now = Carbon::now()->startOfDay();              
        //$fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio);  
	//$fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);
	//$comision = $renta->comision_administrador * $renta->monto / 100;

        //$pagare = $renta->idInmueble->pagares()->create([
            //'id_persona_acreedora' => $renta->idInmueble->idAdministradorReferente()->first()->id,
            //'monto' => $comision, 
            //'id_moneda' => $renta->id_moneda,
            //'fecha_pagare' => $fechaCreacionPagare,                      
            //'enum_estado' => 'PENDIENTE',
            //'enum_clasificacion_pagare' => 'SALARIO_ADMINISTRADOR',
            //'id_tabla_hija' => $renta->id,
        //]);
    //}
}
