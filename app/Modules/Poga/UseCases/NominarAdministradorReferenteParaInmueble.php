<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Persona };
use Raffles\Modules\Poga\Repositories\NominacionRepository;
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
	    'enum_estado' => 'PENDIENTE',
	    'fecha_hora' => \Carbon\Carbon::now(),
            'id_inmueble' => $this->inmueble->id,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->inmueble->id_usuario_creador,
            'referente' => '1',
            'role_id' => '1',
            'usu_alta' => $this->persona->id
        ];

        $nominacion = $repository->updateOrCreate(
            ['enum_estado' => 'PENDIENTE', 'id_inmueble' => $this->inmueble->id, 'id_persona_nominada' => $this->persona->id, 'role_id' => '1'],
            $data
        );
        //$nominacion = $repository->updateOrCreate(['id_persona_nominada' => $data['id_persona_nominada'], 'id_inmueble' => $data['id_inmueble']], $data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $usuario = $personaNominada->user;

        if ($usuario) {
            $usuario->notify(new PersonaNominadaParaInmueble($personaNominada, $nominacion));
        }

        return $nominacion;
    }
}
