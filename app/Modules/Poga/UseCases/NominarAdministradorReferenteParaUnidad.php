<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Unidad, Persona };
use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaUnidad;

use Illuminate\Foundation\Bus\Dispatchable;

class NominarAdministradorReferenteParaUnidad
{
    use Dispatchable;

    /**
     * The Persona and Unidad models.
     *
     * @var Persona  $persona  The Persona model.
     * @var Unidad   $unidad The Unidad model.
     */
    protected $persona, $unidad;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Unidad   $unidad The Unidad model.
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
     * @param NominacionRepository $repository The NominacionRepository object.
     *
     * @return void
     */
    public function handle(NominacionRepository $repository)
    {
        $data = [
            'enum_estado' => 'EN_CURSO',
            'id_inmueble' => $this->unidad->id_inmueble,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->unidad->idInmueble->id_usuario_creador,
            'referente' => '1',
            'role_id' => '1',
            'usu_alta' => $this->persona->id
        ];

        $nominacion = $repository->create($data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $personaNominada->idUsuarioCreador->notify(new PersonaNominadaParaUnidad($personaNominada, $nominacion, $this->unidad));

        return $nominacion;
    }
}
