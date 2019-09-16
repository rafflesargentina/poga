<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, InmueblePadre, User };
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

        $this->nominarOAsignarPropietario($rPersona, $inmueble);

        $this->user->notify(new InmuebleActualizado($inmueble, $this->user));

        return $inmueblePadre;
    }

    /**
     * Actualizar Dirección.
     *
     * @param  DireccionRepository $repository The DireccionRepository object.
     *
     * @return \Raffles\Modules\Poga\Models\Direccion
     */
    protected function actualizarDireccion(DireccionRepository $repository)
    {
        return $repository->update($this->inmueblePadre->idDirecccion, $this->data['idDireccion'])[1];
    }

    /**
     * Actualizar Inmueble.
     *
     * @param  InmuebleRepository $repository The InmuebleRepository object.
     *
     * @return Inmueble
     */
    protected function actualizarInmueble(InmuebleRepository $repository)
    {
        return $repository->update($this->inmueblePadre->idInmueble, $this->data['idInmueble'])[1];
    }

    /**
     * Actualizar InmueblePadre.
     *
     * @param  InmueblePadreRepository $repository The InmueblePadreRepository object.
     *
     * @return InmueblePadre
     */
    protected function actualizarInmueblePadre(InmueblePadreRepository $repository)
    {
        $inmueblePadre = $repository->update($this->inmueblePadre, $this->data['idInmueblePadre'])[1];

        return $inmueblePadre;
    }

    /**
     * Sincronizar Características.
     *
     * @param  Inmueble $inmueble The Inmueble model.
     *
     * @return void
     */
    protected function sincronizarCaracteristicas($inmueble)
    {
        if (array_key_exists('caracteristicas', $this->data)) {
            $caracteristicas = $this->data['caracteristicas'];
            $inmueble->caracteristicas()->sync([]);
            foreach($caracteristicas as $caracteristica) {
                $inmueble->caracteristicas()->attach($caracteristica, ['enum_estado' => 'ACTIVO']);
            }
        }
    }

    /**
     * Sincronizar Formatos.
     *
     * @param  Inmueble $inmueble The Inmueble model.
     *
     * @return void
     */
    protected function sincronizarFormatos($inmueble)
    {
        $formatos = $this->data['formatos'];
        $inmueble->formatos()->sync($formatos);
    }

    /**
     * Nominar o Asignar Propietario Referente.
     *
     * @param  PersonaRepository $repository The PersonaRepository object.
     * @param  Inmueble          $inmueble   The Inmueble model.
     *
     * @return void
     */
    protected function nominarOAsignarPropietario(PersonaRepository $repository, Inmueble $inmueble)
    {
        // idPropietarioReferente no está presente en el array?
        if (array_key_exists('idPropietarioReferente', $this->data)) {
            $user = $this->user;

            $id = $this->data['idPropietarioReferente'];

            // idPropietarioReferente no está vacío?
            if ($id) {
                // idPropietarioReferente es distinto al id de la persona del usuario?
                if ($id != $user->id_persona) {
                    $persona = $repository->findOrFail($id);

                    $this->dispatch(new NominarPropietarioReferenteParaInmueble($persona, $inmueble, $this->user));
                } else {
                    $persona = $user->idPersona;
                    $this->dispatch(new RelacionarPropietarioReferente($persona, $inmueble));
                }
            }
	}
    }
}
