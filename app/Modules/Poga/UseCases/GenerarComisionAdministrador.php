<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Renta;
use Raffles\Modules\Poga\Notifications\{ PagareCreadoPersonaDeudora, PagareCreadoAdministradorReferente };
use Raffles\Modules\Poga\Repositories\PagareRepository;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerarComisionAdministrador
{
    use DispatchesJobs;

    /**
     * The Renta model.
     *
     * @var  Renta
     */
    protected $renta;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Renta $renta)
    {
        $this->renta = $renta;
    }

    /**
     * Execute the job.
     *
     * @param  PagareRepository $repository The PagareRepository object.
     *
     * @return void
     */
    public function handle(PagareRepository $repository)
    {
        $now = Carbon::now();
        $comision = $this->renta->comision_administrador * $this->renta->monto / 100;

        $inmueble = $this->renta->idInmueble;

	$pagare = $repository->create([
	    'enum_clasificacion_pagare' => 'COMISION_RENTA_ADMIN',
            'enum_estado' => 'PENDIENTE',
	    'fecha_pagare' => $now,
	    'id_inmueble' => $this->renta->id_inmueble,
            'id_moneda' => $this->renta->id_moneda,
            'id_persona_acreedora' => $inmueble->idAdministradorReferente->id_persona,
	    'id_persona_deudora' => $inmueble->idPropietarioReferente->id_persona,
            'id_tabla_hija' => $this->renta->id,
            'monto' => $comision,
        ])[1];

        $acreedor = $pagare->idPersonaAcreedora->user;
        $deudor = $pagare->idPersonaDeudora->user;

        // El acreedor es el administrador.
        $acreedor->notify(new PagareCreadoAdministradorReferente($pagare));

        // El deudor es el propietario. Puede que no tenga usuario registrado.
        if ($deudor) {
            $deudor->notify(new PagareCreadoPersonaDeudora($pagare));
        }	
    }
}
