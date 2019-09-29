<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Persona, Unidad };
use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaUnidad;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NominarPropietarioReferenteParaUnidad
{
    use Dispatchable,AuthorizesRequests;

    /**
     * The Persona and Unidad models.
     *
     * @var Persona  $persona  The Persona model.
     * @var Unidad   $unidad   The Unidad model.
     */
    protected $persona, $unidad;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Unidad   $unidad   The Unidad model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Unidad $unidad)
    {
        $this->persona = $persona;
        $this->unidad = $unidad;
    }

    /**
     * Execute the job.
     *
     * @param NominacionRepository $repository  The NominacionRepository object.
     *
     * @return void
     */
    public function handle(NominacionRepository $repository)
    {
        $data = [
            'enum_estado' => 'EN_CURSO',
            'id_inmueble' => $this->unidad->id_inmueble,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->user->id,
            'referente' => '1',
            'role_id' => '4',
            'usu_alta' => $this->user->id
        ];

        $nominacion = $repository->create($data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $user = $personaNominada->user;

        if ($user) {
            $user->notify(new PersonaNominadaParaUnidad($personaNominada, $nominacion, $this->unidad));
        }

        return $nominacion;
    }
}
