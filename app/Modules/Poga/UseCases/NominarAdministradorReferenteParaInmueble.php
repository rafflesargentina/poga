<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Persona, User };
use Raffles\Modules\Poga\Repositories\{ NominacionRepository, UserRepository };
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaInmueble;

use Illuminate\Foundation\Bus\Dispatchable;

class NominarAdministradorReferenteParaInmueble
{
    use Dispatchable;

    /**
     * The Persona and Inmueble models.
     *
     * @var Persona  $persona  The Persona model.
     * @var Inmueble $inmueble The Inmueble model.
     * @var User     $user     The User model.
     */
    protected $persona, $inmueble, $user;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Inmueble $inmueble The Inmueble model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Inmueble $inmueble, User $user)
    {
        $this->persona = $persona;
        $this->inmueble = $inmueble;
        $his->user = $user;
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
        $data = [
            'enum_estado' => 'EN_CURSO',
            'id_inmueble' => $this->inmueble->id,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->inmueble->id_usuario_creador,
            'referente' => '1',
            'role_id' => '1',
            'usu_alta' => $this->persona->id
        ];

        $nominacion = $repository->create($data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $usuarioCreador = $rUser->find($personaNominada->id_usuario_creador);

        if ($usuarioCreador) {
            $usuarioCreador->notify(new PersonaNominadaParaInmueble($personaNominada, $nominacion));
        }

        return $nominacion;
    }
}
