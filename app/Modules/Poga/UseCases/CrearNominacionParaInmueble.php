<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\{ NominacionRepository, UserRepository };
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaInmueble;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CrearNominacionParaInmueble
{
    use Dispatchable,AuthorizesRequests;

    /**
     * The form data.
     *
     * @var array $data
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data The form data.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param NominacionRepository $repository The NominacionRepository object.
     * @param UserRepository       $rUser      The UserRepository object.
     *
     * @return void
     */
    public function handle(NominacionRepository $repository, UserRepository $rUser)
    {
        $nominacion = $repository->create($this->data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $usuarioCreador = $rUser->find($nominacion->idPersonaNominada->id_usuario_creador);

        if ($usuarioCreador) {
            $usuarioCreador->notify(new PersonaNominadaParaInmueble($personaNominada, $nominacion));
        }

        return $nominacion;
    }
}
