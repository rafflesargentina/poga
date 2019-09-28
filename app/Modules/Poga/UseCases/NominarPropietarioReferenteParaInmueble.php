<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Persona };
use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaInmueble;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NominarPropietarioReferenteParaInmueble
{
    use Dispatchable;

    /**
     * The Persona and Inmueble models.
     *
     * @var Persona  $persona  The Persona model.
     * @var Inmueble $inmueble The Inmueble model.
     */
    protected $persona, $inmueble;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Inmueble $inmueble The Inmueble model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Inmueble $inmueble)
    {
        $this->persona = $persona;
        $this->inmueble = $inmueble;
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
        $data = [
            'enum_estado' => 'EN_CURSO',
            'id_inmueble' => $this->inmueble->id,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->user->id,
            'referente' => '1',
            'role_id' => '4',
            'usu_alta' => $this->user->id,
        ];

        $nominacion = $repository->create($data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $user = $personaNominada->user;

        if ($user) {
            $user->notify(new PersonaNominadaParaInmueble($personaNominada, $nominacion));
        }

        return $nominacion;
    }
}
