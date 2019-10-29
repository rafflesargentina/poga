<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Nominacion;
use Raffles\Modules\Poga\Repositories\{ NominacionRepository, RentaRepository };
use Raffles\Modules\Poga\Notifications\EstadoNominacionActualizado;

use Illuminate\Foundation\Bus\DispatchesJobs;

class RechazarNominacion
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
     * @param RentaRepository      $rRenta     The RentaRepository object.
     *
     * @return void
     */
    public function handle(NominacionRepository $repository, RentaRepository $rRenta)
    {
        $nominacion = $repository->update($this->nominacion, ['enum_estado' => 'INACTIVO'])[1];

        switch ($this->nominacion->role_id) {
            case 3:
                return $this->handleInquilino($nominacion, $rRenta);
	    case 4:
		return $this->handlePropietario($nominacion);
	}

	return $nominacion;
    }

    /**
     * Handle Inquilino: cambia estado de nominación y renta asociada a INACTIVO, y envía notificaciones.
     *
     * @param  Nominacion      $nominacion The Nominacion model.
     * @param  RentaRepository $repository     The RentaRepository object.
     *
     * @return Nominacion
     */
    protected function handleInquilino(Nominacion $nominacion, RentaRepository $repository)
    {
        $renta = $nominacion->idPersonaNominada->rentas->where('id_inmueble', $nominacion->id_inmueble)->where('enum_estado', 'PENDIENTE')->first();
        if ($renta) {
            $repository->update($renta, ['enum_estado' => 'INACTIVO']);
	}

        $userPersonaNominada = $nominacion->idPersonaNominada->user;
        if ($userPersonaNominada) {
            $userPersonaNominada->notify(new EstadoNominacionActualizado($nominacion));
        }

	$userAdministradorReferente = $nominacion->idInmueble->idAdministradorReferente->idPersona->user;
        $userAdministradorReferente->notify(new EstadoNominacionActualizado($nominacion));

	return $nominacion;
    }

    /**
     * Handle Propietario: envía notificaciones.
     *
     * @param  Nominacion      $nominacion The Nominacion model.
     *
     * @return Nominacion
     */
    protected function handlePropietrario(Nominacion $nominacion)
    {
        $userPersonaNominada = $nominacion->idPersonaNominada->user;
        if ($userPersonaNominada) {
            $userPersonaNominada->notify(new EstadoNominacionActualizado($nominacion));
        }

	$userAdministradorReferente = $nominacion->idInmueble->idAdministradorReferente->idPersona->user;
        $userAdministradorReferente->notify(new EstadoNominacionActualizado($nominacion));

        return $nominacion;
    }
}
