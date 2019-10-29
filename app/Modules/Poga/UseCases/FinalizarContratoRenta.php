<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\{ RentaFinalizada, RentaFinalizadaInquilinoReferente, RentaFinalizadaPropietarioReferente };

use Illuminate\Foundation\Bus\DispatchesJobs;

class FinalizarContratoRenta
{
    use DispatchesJobs;
    
    /**
     * The Renta model.
     *
     * @var Renta
     */
    protected $renta;

    /**
     * The form data and User model.
     *
     * @var array
     * @var User
     */
    protected $data, $user;

    /**
     * Create a new job instance.
     *
     * @param Renta $renta The Renta model.
     * @param array $data  The form data.
     * @param User  $user  The User model.
     *
     * @return void
     */
    public function __construct(Renta $renta, $data, User $user)
    {
        $this->renta = $renta;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return void
     */
    public function handle(RentaRepository $repository)
    {
        $renta = $repository->update($this->renta, array_merge($this->data, ['enum_estado' => 'FINALIZADO']))[1];

	$this->handleNotifications($renta);

        return $renta;
    }

    protected function handleNotifications(Renta $renta)
    {
	// Administrador
	$this->user->notify(new RentaFinalizada($renta));

        $inquilino = $renta->idInquilino;
	$inquilinoUser = $inquilino->user;
	if ($inquilinoUser) {
	    $inquilinoUser->notify(new RentaFinalizadaInquilinoReferente($renta));
	}

	$propietario = $renta->idInmueble->idPropietarioReferente->idPersona;
	$propietarioUser = $propietario->user;
        if ($propietarioUser) {
            $propietarioUser->notify(new RentaFinalizadaPropietarioReferente($renta));
	}
    }
}
