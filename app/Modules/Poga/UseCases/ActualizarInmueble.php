<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ InmueblePadre, User };
use Raffles\Modules\Poga\Repositories\{ DireccionRepository, InmuebleRepository, InmueblePadreRepository, PersonaRepository };
use Raffles\Modules\Poga\Notifications\InmuebleActualizado;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarInmueble
{
    use DispatchesJobs;

    /**
     * The InmueblePadre model.
     *
     * @var InmueblePadre $inmueblePadre
     */
    protected $inmueblePadre;

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
    public function __construct(InmueblePadre $inmueblePadre, $data, User $user)
    {
        $this->inmueblePadre = $inmueblePadre;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param DireccionRepository     $rDireccion     The DireccionRepository object.
     * @param InmuebleRepository      $rInmueble      The InmuebleRepository object.
     * @param InmueblePadreRepository $rInmueblePadre The InmueblePadreRepository object.
     * @param PersonaRepository       $rPersona       The PersonaRepository object.
     *
     * @return void
     */
    public function handle(DireccionRepository $rDireccion, InmuebleRepository $rInmueble, InmueblePadreRepository $rInmueblePadre, PersonaRepository $rPersona)
    {
        $inmueblePadre = $this->actualizarInmueblePadre($rInmueblePadre);

        $direccion = $this->actualizarDireccion($rDireccion);
        $inmueble = $this->actualizarInmueble($rInmueble);

        $this->sincronizarCaracteristicas($inmueble);
        $this->sincronizarFormatos($inmueble);

        //if ($this->data['administrador'] === 'yo' || $this->data['idAdministradorReferente'] === $this->user->id) {
            //$inmueble->idAdministradorReferente()->create(array_merge($this->data['idPersona'],
                //[
                    //'id_persona' => $this->user->idPersona->id,
                //]
            //));
        //}

        //$this->nominarOAsignarAdministrador($rPersona, $inmueble);
        //$this->nominarOAsignarPropietario($rPersona, $inmueble);

        $this->user->notify(new InmuebleActualizado($inmueble, $this->user));

        return $inmueblePadre;
    }

    /**
     * @param DireccionRepository $repository The DireccionRepository object.
     */
    protected function actualizarDireccion(DireccionRepository $repository)
    {
        return $repository->update($this->inmueblePadre->idDirecccion, $this->data['idDireccion'])[1];
    }

    /**
     * @param InmuebleRepository $repository The InmuebleRepository object.
     */
    protected function actualizarInmueble(InmuebleRepository $repository)
    {
        return $repository->update($this->inmueblePadre->idInmueble, $this->data['idInmueble'])[1];
    }

    /**
     * @param InmueblePadreRepository $repository The InmueblePadreRepository object.
     */
    protected function actualizarInmueblePadre(InmueblePadreRepository $repository)
    {
        $inmueblePadre = $repository->update($this->inmueblePadre, $this->data['idInmueblePadre'])[1];

        return $inmueblePadre;
    }

    /**
     * @param Inmueble $inmueble The Inmueble model.
     */
    protected function sincronizarCaracteristicas($inmueble)
    {
        $caracteristicas = $this->data['caracteristicas'];
        if ($caracteristicas) {
            $inmueble->caracteristicas()->sync([]);
            foreach($caracteristicas as $caracteristica) {
                $inmueble->caracteristicas()->attach($caracteristica, ['enum_estado' => 'ACTIVO']);
            }
        }

        return $inmueble->caracteristicas;
    }

    /**
     * @param Inmueble $inmueble The Inmueble model.
     */
    protected function sincronizarFormatos($inmueble)
    {
        $formatos = $this->data['formatos'];
        if ($formatos) {
            $inmueble->formatos()->sync($formatos);
        }
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Inmueble          $inmueble   The Inmueble model.
     */
    protected function nominarOAsignarAdministrador(PersonaRepository $repository, Inmueble $inmueble)
    {
        $id = $this->data['idAdministradorReferente'];

        if ($id) {
            $persona = $repository->find($id)->first();

            if ($id !== $this->user->id) {
                $this->dispatch(new NominarAdministradorReferenteParaInmueble($persona, $inmueble));
            } else {
                $this->dispatch(new RelacionarAdministradorReferente($persona, $inmueble, $this->data['idPersona']));
            }
        }
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Inmueble          $inmueble   The Inmueble model.
     */
    protected function nominarOAsignarPropietario(PersonaRepository $repository, Inmueble $inmueble)
    {
        $id = $this->data['idPropietarioReferente'];

        if ($id) {
            $persona = $repository->find($id)->first();

            if ($id !== $this->user->id) {
                $this->dispatch(new NominarPropietarioReferenteParaInmueble($persona, $inmueble));
            } else {
                $this->dispatch(new RelacionarPropietarioReferente($persona, $inmueble));
            }
        }
    }
}
