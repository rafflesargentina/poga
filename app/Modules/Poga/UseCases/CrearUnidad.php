<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Unidad, User };
use Raffles\Modules\Poga\Repositories\{ InmuebleRepository, PersonaRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\UnidadCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearUnidad
{
    use DispatchesJobs;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user;

    /**
     * Create a new job instance.
     *
     * @param array $data The form data.
     * @param User  $user The User model.
     *
     * @return void
     */
    public function __construct($data, User $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param InmuebleRepository      $rInmueble      The InmuebleRepository object.
     * @param UnidadRepository        $rUnidad        The UnidadRepository object.
     * @param PersonaRepository       $rPersona       The PersonaRepository object.
     *
     * @return void
     */
    public function handle(InmuebleRepository $rInmueble, UnidadRepository $rUnidad, PersonaRepository $rPersona)
    {
        $inmueble = $this->crearInmueble($rInmueble);

        $unidad = $this->crearUnidad($rUnidad, $inmueble);

        if ($this->data['administrador'] === 'yo') {
            $inmueble->idAdministradorReferente()->create(array_merge($this->data['idPersona'],
                [
                    'id_persona' => $this->user->idPersona->id,
                ]
            ));
        }

        $this->nominarAdministrador($rPersona, $unidad);
        $this->nominarPropietario($rPersona, $unidad);

        $this->user->notify(new UnidadCreada($unidad, $this->user));

        return $unidad;
    }

    /**
     * @param InmuebleRepository $repository The InmuebleRepository object.
     */
    protected function crearInmueble(InmuebleRepository $repository)
    {
        return $repository->create(array_merge($this->data['idInmueble'],
            [
                'enum_estado' => 'ACTIVO',
                'enum_tabla_hija' => 'UNIDADES',
                'id_usuario_creador' => $this->user->id,
            ]
        ))[1];
    }

    /**
     * @param UnidadRepository $repository The UnidadRepository object.
     * @param Inmueble         $inmueble The Inmueble model.
     */
    protected function crearUnidad(UnidadRepository $repository, Inmueble $inmueble)
    {
        $unidad = $repository->create(array_merge($this->data['unidad'],
            [
                'id_inmueble' => $inmueble->id
            ]
        ))[1];

        $inmueble->id_tabla_hija = $unidad->id;
        $inmueble->save();

        return $unidad;
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Unidad            $unidad     The Unidad model.
     */
    protected function nominarAdministrador(PersonaRepository $repository, Unidad $unidad)
    {
        $id = $this->data['idAdministradorReferente'];

        if ($id) {

            $persona = $repository->find($id)->first();

            $this->dispatch(new NominarAdministradorReferenteParaUnidad($persona, $unidad));
        }
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Unidad            $unidad     The Unidad model.
     */
    protected function nominarPropietario(PersonaRepository $repository, Unidad $unidad)
    {
        $id = $this->data['idPropietarioReferente'];

        if ($id) {

            $persona = $repository->find($id)->first();

            $this->dispatch(new NominarPropietarioReferenteParaUnidad($persona, $unidad));
        }
    }
}
