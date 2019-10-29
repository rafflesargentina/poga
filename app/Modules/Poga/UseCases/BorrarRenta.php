<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Renta, User };
use Raffles\Modules\Poga\Notifications\RentaBorrada;
use Raffles\Modules\Poga\Repositories\{ NominacionRepository, RentaRepository };

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarRenta
{
    use Dispatchable;

    /**
     * The Renta and User models.
     *
     * @var Renta
     */
    protected $renta, $user;

    /**
     * Create a new job instance.
     *
     * @param Renta $renta The Renta model.
     * @param User  $user  The User model.
     *
     * @return void
     */
    public function __construct(Renta $renta, User $user)
    {
        $this->renta = $renta;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param RentaRepository      $repository  The RentaRepository object.
     * @param NominacionRepository $rNominacion The NominacionRepository object.
     *
     * @return Renta
     */
    public function handle(RentaRepository $repository, NominacionRepository $rNominacion)
    {
        $renta = $repository->update($this->renta, ['enum_estado' => 'INACTIVO'])[1];

        $this->borrarNominacionesPendientes($renta->idInmueble, $rNominacion);

        $this->user->notify(new RentaBorrada($renta));

        return $renta;
    }

    protected function borrarNominacionesPendientes(Inmueble $inmueble, NominacionRepository $repository)
    {
        $nominacionesPendientes = $repository->findWhere(['enum_estado' => 'PENDIENTE', 'id_inmueble' => $inmueble->id, 'id_persona_nominada' => $this->renta->id_inquilino]);
    
	foreach ($nominacionesPendientes as $nominacion) {
            $nominacion->delete(); 
	}
    }
}
