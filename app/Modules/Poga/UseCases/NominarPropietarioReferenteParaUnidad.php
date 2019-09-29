<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Persona, Unidad, User };
use Raffles\Modules\Poga\Repositories\NominacionRepository;
use Raffles\Modules\Poga\Notifications\PersonaNominadaParaUnidad;

use Illuminate\Foundation\Bus\Dispatchable;

class NominarPropietarioReferenteParaUnidad
{
    use Dispatchable;

    /**
     * The Persona and Unidad models.
     *
     * @var Persona  $persona  The Persona model.
     * @var Unidad   $unidad   The Unidad model.
     * @var User     $user     The User model.
     */
    protected $persona, $unidad, $user;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Unidad   $unidad   The Unidad model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Unidad $unidad, User $user)
    {
        $this->persona = $persona;
	$this->unidad = $unidad;
	$this->user = $user;
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
            'fecha_hora' => \Carbon\Carbon::now(),
            'id_inmueble' => $this->unidad->id_inmueble,
            'id_persona_nominada' => $this->persona->id,
            'id_usuario_principal' => $this->user->id,
            'referente' => '1',
            'role_id' => '4',
            'usu_alta' => $this->user->id
        ];

	//$nominacion = $repository->updateOrCreate(['id_persona_nominada' => $data['id_persona_nominada'], 'id_inmueble' => $data['id_inmueble']], $data)[1];
	$nominacion = $repository->create($data)[1];

        $personaNominada = $nominacion->idPersonaNominada;
        $user = $personaNominada->user;

        if ($user) {
            $user->notify(new PersonaNominadaParaUnidad($personaNominada, $nominacion, $this->unidad));
        }

        return $nominacion;
    }
}
