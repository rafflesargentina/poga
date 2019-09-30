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
            $fechaInicioRenta = Carbon::createFromFormat('Y-m-d', $renta->fecha_inicio); 
            $inmueble = Inmueble::find($renta->id_inmueble);   

            //Obtencion de pagaré vencidos
            $pagares = $inmueble->pagares()
            ->where('enum_clasificacion_pagare', 'RENTA')
            ->where('fecha_vencimiento', '>', $fechaLimite)->get();          

            $now = Carbon::now();    

            foreach($pagares as $pagare) {                            
              
                $multaRenta = $renta->multas()->firstOrCreate([ 
                    'id_pagare' => $pagare->id, 
                    'mes' => $now->month, 
                    'anno' => $now->year,
                ]);                
               
                $inicioMes = Carbon::now()->startOfMonth();  
                $finMes = Carbon::now()->endOfMonth();                 
                
                $pagareActual = $inmueble->pagares()
                ->where('fecha_pagare','>',$inicioMes)
                ->where('fecha_pagare','<',$finMes)
                ->where('enum_clasificacion_pagare','=','MULTA_RENTA')->first();        
                
                
                if(count($pagareActual)==0){


                    $fechaCreacionPagare = Carbon::create($now->year, $now->month, $fechaInicioRenta->day, 0, 0, 0);
            
                    $monto = $renta->monto_multa_dia;

                    Pagare::create([
                        'id_inmueble' => $inmueble->id,
                        'fecha_pagare' => $fechaCreacionPagare,
                        'id_persona_acreedora' => $renta->idInmueble->idPropietarioReferente()->first()->id,
                        'id_persona_deudora' => $renta->id_inquilino,
                        'id_moneda'=> $renta->id_moneda,
                        'enum_estado'=>'PENDIENTE',
                        'enum_clasificacion_pagare'=>'MULTA_RENTA',
                        'id_tabla'=> $multaRenta->id ,
                        'monto' => $monto, 
                    ]);
                }
                else{

                    $monto = $pagareActual->monto + $renta->monto_multa_dia;
                
                    $pagareActual->update([
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
