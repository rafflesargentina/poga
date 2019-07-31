<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaInmueble;

use Illuminate\Foundation\Bus\Dispatchable;

class CrearNominacionParaInmueble
{
    use Dispatchable;

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
     *
     * @return void
     */
    public function handle(NominacionRepository $repository)
    {
        $nominacion = $repository->create($this->data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $personaNominada->idUsuarioCreador->notify(new PersonaNominadaParaInmueble($personaNominada, $nominacion));

        return $nominacion;
    }
}
