<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Unidad, User };
use Raffles\Modules\Poga\Repositories\{ InmuebleRepository, PersonaRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\UnidadCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarUnidad
{
    use DispatchesJobs;

    /**
     * The Unidad model.
     *
     * @var Unidad $unidad
     */
    protected $unidad;

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
     * @param Unidad $unidad The Unidad model.
     * @param array  $data The form data.
     * @param User   $user The User model.
     *
     * @return void
     */
    public function __construct(Unidad $unidad, $data, User $user)
    {
        $this->unidad = $unidad;
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
        $inmueble = $this->actualizarInmueble($rInmueble);

        $unidad = $this->actualizarUnidad($rUnidad);

        $this->nominarOAsignarPropietario($rPersona, $unidad);

        $this->user->notify(new UnidadActualizada($unidad, $this->user));

        return $unidad;
    }

    /**
     * @param InmuebleRepository $repository The InmuebleRepository object.
     */
    protected function actualizarInmueble(InmuebleRepository $repository)
    {
        return $repository->update($this->unidad->idInmueble, $this->data['idInmueble'])[1];
    }

    /**
     * @param UnidadRepository $repository The UnidadRepository object.
     */
    protected function actualizarUnidad(UnidadRepository $repository)
    {
        return $repository->update($this->unidad, $this->data['unidad'])[1];
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Unidad            $unidad     The Unidad model.
     */
    protected function nominarOAsignarPropietario(PersonaRepository $repository, Unidad $unidad)
    {
        $id = $this->data['idPropietarioReferente'];

        if ($id) {
            $persona = $repository->find($id);

            if ($id !== $this->user->id_persona) {
\Log::info("NOMINAR");
                $this->dispatch(new NominarPropietarioReferenteParaUnidad($persona, $unidad));
            } else {
\Log::info("RELACIONAR");
                $this->dispatch(new RelacionarPropietarioReferente($persona, $unidad->idInmueble));
            }
        }
    }
}