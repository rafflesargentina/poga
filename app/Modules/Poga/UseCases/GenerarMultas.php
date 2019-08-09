<?php

namespace Raffles\Modules\Poga\UseCases;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Models\Inmueble;
use Raffles\Modules\Poga\Models\Pagare;

class GenerarMultas implements ShouldQueue
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
        $rentas = $this->rRenta->where('multa', 1)->where('enum_estado', 'ACTIVO')->get();
            

        foreach($rentas as $renta) {
            

            $fechaLimite = Carbon::now()->startOfMonth()->addDays($renta->dia_mes_pago + $renta->dias_multa-1);
           
            $inmueble = Inmueble::find($renta->id_inmueble);       

            //Obtencion de pagaré vencidos
            $pagares = $inmueble->pagares()
            ->where('enum_clasificacion_pagare', 'RENTA')
            ->where('fecha_vencimiento', '>', $fechaLimite)->get();          

            $now = Carbon::now();    

            foreach($pagares as $pagare) {  
                          
                $multaRenta = $renta->multas()->firstOrCreate([ //diferencia entre updateOrCrete?
                    'id_pagare' => $pagare->id, 
                    'mes' => $now->month, 
                    'anno' => $now->year,
                ]/*,[
                    'id_pagare' => $pagare->id, 
                    'mes' => $now->month, 
                    'anno' => $now->year,
                ]*/); 

                $montoTotal = $pagare->monto + $renta->monto_multa_dia;

                

                $inmueble->pagares()->updateOrCreate([
                    'id_persona_adeudora' => $renta->id_inquilino,
                    'id_moneda'=> $renta->id_moneda,
                    'fecha_pagare'=> $now->toDateString(),
                    'enum_estado'=>'PENDIENTE',
                    'enum_clasificacion_pagare'=>'MULTA_RENTA',
                    'id_tabla'=> $multaRenta->id ,
                ]/*,[
                    'id_persona_adeudora' => $renta->id_inquilino,
                    'id_moneda'=> $renta->id_moneda,
                    'fecha_pagare'=> $now->toDateString(),
                    'enum_estado'=>'PENDIENTE',
                    'enum_clasificacion_pagare'=>'MULTA_RENTA',
                    'id_tabla'=> $multaRenta->id ,
                    'monto' => $montoTotal, 
                ]*/);
                
            }
        }
    }
}
