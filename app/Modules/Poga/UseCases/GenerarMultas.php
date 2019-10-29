<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Models\Inmueble;
use Raffles\Modules\Poga\Models\Pagare;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerarMultas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param  RentaRepository $repository The RentaRepository object.
     *
     * @return void
     */
    public function handle(RentaRepository $repository)
    {
        $rentas = $repository->findWhere(['multa' => 1, 'enum_estado' => 'ACTIVO']);
	
	$now = Carbon::now();

        foreach($rentas as $renta) {
            $fechaLimite = $now->startOfMonth()->addDays($renta->dia_mes_pago + $renta->dias_multa - 1)->toDateString();
	    $fechaInicioRenta = $renta->fecha_inicio;

            $inmueble = $renta->idInmueble;

            // Obtiene pagares vencidos.
            $pagares = $inmueble->pagares()
                ->where('enum_clasificacion_pagare', 'RENTA')
		->where('enum_estado', 'PENDIENTE')
		->where('fecha_vencimiento', '>', $fechaLimite)
	        ->get();
    
            foreach($pagares as $pagare) {                            
                $multaRenta = $renta->multas()->firstOrCreate([ 
                    'id_pagare' => $pagare->id, 
                    'mes' => $now->month, 
                    'anno' => $now->year,
                ]);
               
                $inicioMes = $now->startOfMonth()->toDateString();
                
		$pagareActual = $inmueble->pagares()
		    ->where('enum_estado', 'PENDIENTE')
                    ->where('fecha_pagare','>=',$inicioMes)
		    ->where('enum_clasificacion_pagare', 'MULTA_RENTA')
		    ->first();
                
		if(!$pagareActual){
                    $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);
                    $monto = $renta->monto_multa_dia;

                    Pagare::create([
                        'id_inmueble' => $inmueble->id,
                        'fecha_pagare' => $fechaCreacionPagare,
                        'id_persona_acreedora' => $renta->idInmueble->idPropietarioReferente->id_persona,
                        'id_persona_deudora' => $renta->id_inquilino,
                        'id_moneda'=> $renta->id_moneda,
                        'enum_estado'=>'PENDIENTE',
                        'enum_clasificacion_pagare'=>'MULTA_RENTA',
                        'id_tabla'=> $multaRenta->id ,
                        'monto' => $monto, 
                    ]);
		} else {
		    $monto = $pagareActual->monto + $renta->monto_multa_dia;
                    return $pagareActual->update([
                        'id_persona_deudora' => $renta->id_inquilino,
                        'id_moneda'=> $renta->id_moneda,
                        'enum_estado'=>'PENDIENTE',
                        'enum_clasificacion_pagare'=>'MULTA_RENTA',
                        'id_tabla'=> $multaRenta->id ,
                        'monto' => $monto, 
                    ]);
                }
            }
        }
    }
}
