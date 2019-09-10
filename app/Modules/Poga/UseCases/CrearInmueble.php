<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Direccion, Inmueble, User };
use Raffles\Modules\Poga\Repositories\{ DireccionRepository, InmuebleRepository, InmueblePadreRepository, PersonaRepository };
use Raffles\Modules\Poga\Notifications\InmuebleCreado;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearInmueble
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
     * @param DireccionRepository     $rDireccion     The DireccionRepository object.
     * @param InmuebleRepository      $rInmueble      The InmuebleRepository object.
     * @param InmueblePadreRepository $rInmueblePadre The InmueblePadreRepository object.
     * @param PersonaRepository       $rPersona       The PersonaRepository object.
     *
     * @return void
     */
    public function handle(DireccionRepository $rDireccion, InmuebleRepository $rInmueble, InmueblePadreRepository $rInmueblePadre, PersonaRepository $rPersona)
    {
        $direccion = $this->crearDireccion($rDireccion);
        $inmueble = $this->crearInmueble($rInmueble);
        $this->adjuntarFormatos($inmueble);
        $inmueblePadre = $this->crearInmueblePadre($rInmueblePadre, $direccion, $inmueble);

        if ($this->data['administrador'] === 'yo' || $this->data['idAdministradorReferente'] === $this->user->id_persona) {
            $inmueble->idAdministradorReferente()->create(array_merge($this->data['idPersona'],
                [
                    'id_persona' => $this->user->id_persona,
                ]
            ));
        }

        $this->nominarOAsignarAdministrador($rPersona, $inmueble);
        $this->nominarOAsignarPropietario($rPersona, $inmueble);

        $this->user->notify(new InmuebleCreado($inmueble, $this->user));

        return $inmueblePadre;
    }

    /**
     * @param Inmueble $inmueble The Inmueble model.
     */
    protected function adjuntarFormatos($inmueble)
    {
        $formatos = $this->data['formatos'];
        if ($formatos) {
            $inmueble->formatos()->attach($formatos);
        }
    }

    /**
     * @param DireccionRepository $repository The DireccionRepository object.
     */
    protected function crearDireccion(DireccionRepository $repository)
    {
        return $repository->create($this->data['idDireccion'])[1];
    }

    /**
     * @param InmuebleRepository $repository The InmuebleRepository object.
     */
    protected function crearInmueble(InmuebleRepository $repository)
    {
        return $repository->create(array_merge($this->data['idInmueble'],
            [
                'id_usuario_creador' => $this->user->id
            ]
        ))[1];
    }

    /**
     * @param InmueblePadreRepository $repository The InmueblePadreRepository object.
     * @param Direccion               $direccion  The Direccion model.
     * @param Inmueble                $inmueble   The Inmueble model.
     */
    protected function crearInmueblePadre(InmueblePadreRepository $repository, Direccion $direccion, Inmueble $inmueble)
    {
        $inmueblePadre = $repository->create(array_merge($this->data['idInmueblePadre'],
            [
                'id_direccion' => $direccion->id,
                'id_inmueble' => $inmueble->id,
            ]
        )
        )[1];

        $inmueble->id_tabla_hija = $inmueblePadre->id;
        $inmueble->save();

        return $inmueblePadre;
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
