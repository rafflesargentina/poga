<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Nominacion, User };
use Raffles\Modules\Poga\Notifications\EstadoNominacionActualizado;
use Raffles\Modules\Poga\Repositories\NominacionRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarNominacion
{
    use Dispatchable;

    /**
     * The Nominacion and User models.
     *
     * @var Nominacion
     */
    protected $nominacion, $user;

    /**
     * Create a new job instance.
     *
     * @param Nominacion $nominacion The Nominacion model.
     * @param User       $user       The User model.
     *
     * @return void
     */
    public function __construct(Nominacion $nominacion, User $user)
    {
        $this->nominacion = $nominacion;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param NominacionRepository $repository The NominacionRepository object.
     *
     * @return Nominacion
     */
    public function handle(NominacionRepository $repository)
    {
        $repository->update($this->nominacion->id, ['enum_estado' => 'INACTIVO'])[1];

	// Solo el Administrador puede borrar una nominación.
	$this->user->notify(new EstadoNominacionActualizado($this->nominacion));

	$userPersonaNominada = $nominacion->idPersonaNominada->idPersona->user;
        if ($userPersonaNominada) {
            $userPersonaNominada->notify(new EstadoNominacionActualizado($this->nominacion));
	}

        return $this->nominacion;
    }
}
