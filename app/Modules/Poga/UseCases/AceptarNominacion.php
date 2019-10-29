<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Nominacion, Renta };
use Raffles\Modules\Poga\Repositories\{ InmueblePersonaRepository, NominacionRepository, RentaRepository };
use Raffles\Modules\Poga\Notifications\EstadoNominacionActualizado;

use Illuminate\Foundation\Bus\DispatchesJobs;

class AceptarNominacion
{
    use DispatchesJobs;

    /**
     * The Nominacion model.
     *
     * @var Nominacion $nominacion
     */
    protected $nominacion;

    /**
     * Create a new job instance.
     *
     * @param  Nominacion $nominacion The Nominacion model.
     *
     * @return void
     */
    public function __construct(Nominacion $nominacion)
    {
        $this->nominacion = $nominacion;
    }

    /**
     * Execute the job.
     *
     * @param NominacionRepository $repository The NominacionRepository object.
     *
     * @return void
     */
    public function handle(NominacionRepository $repository, InmueblePersonaRepository $rInmueblePersona, RentaRepository $rRenta)
    {
        switch ($this->nominacion->role_id) {
            case 3:
	        return $this->handleInquilino($repository, $rInmueblePersona, $rRenta);
	    case 4:
	        return $this->handlePropietario($repository, $rInmueblePersona);
	}
    }

    protected function handleInquilino(NominacionRepository $repository, InmueblePersonaRepository $rInmueblePersona, RentaRepository $rRenta)
    {
        $nominacion = $repository->update($this->nominacion, ['enum_estado' => 'ACEPTADO'])[1];

        $inmueblePersona = $rInmueblePersona->create(['id_persona' => $nominacion->id_persona_nominada, 'id_inmueble' => $nominacion->id_inmueble, 'referente' => '1', 'enum_rol' => 'INQUILINO'])[1];

        $renta = $nominacion->idPersonaNominada->rentas->where('id_inmueble', $nominacion->id_inmueble)->where('enum_estado', 'PENDIENTE')->first();
        if ($renta) {
            $renta->update(['enum_estado' => 'ACTIVO']);

	    $this->handleComisionPrimerMesAdministrador($renta);
	    $this->handleGenerarPagareRenta($renta);
	}

	$userPersonaNominada = $nominacion->idPersonaNominada->user;
	if ($userPersonaNominada) {
            $userPersonaNominada->notify(new EstadoNominacionActualizado($nominacion));
	}

	$userAdministradorReferente = $nominacion->idInmueble->idAdministradorReferente->idPersona->user;
        $userAdministradorReferente->notify(new EstadoNominacionActualizado($nominacion));

	return $nominacion;
    }

    protected function handleComisionPrimerMesAdministrador(Renta $renta)
    {
        $pagare = $this->dispatchNow(new GenerarComisionPrimerMesAdministrador($renta));

	return $pagare;
    }

    protected function handleGenerarPagareRenta(Renta $renta)
    {
        $pagare = $this->dispatchNow(new GenerarPagareRentaPrimerMes($renta));

        return $pagare;
    }

    protected function handlePropietario(NominacionRepository $repository, InmueblePersonaRepository $rInmueblePersona)
    {
	$nominacion = $repository->update($this->nominacion, ['enum_estado' => 'ACEPTADO'])[1];

        $inmueblePersona = $rInmueblePersona->create(['id_persona' => $nominacion->id_persona_nominada, 'id_inmueble' => $nominacion->id_inmueble, 'referente' => '1', 'enum_rol' => 'PROPIETARIO'])[1];

        $userPersonaNominada = $nominacion->idPersonaNominada->user;
        if ($userPersonaNominada) {
            $userPersonaNominada->notify(new EstadoNominacionActualizado($nominacion));
	}

	$userAdministradorReferente = $nominacion->idInmueble->idAdministradorReferente->idPersona->user;
        $userAdministradorReferente->notify(new EstadoNominacionActualizado($nominacion));

        return $nominacion;
    }
}
