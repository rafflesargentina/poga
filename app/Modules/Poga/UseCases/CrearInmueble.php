<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Direccion, Inmueble, User };
use Raffles\Modules\Poga\Repositories\{ DireccionRepository, InmuebleRepository, InmueblePadreRepository, PersonaRepository };
use Raffles\Modules\Poga\Notifications\InmuebleCreado;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CrearInmueble
{
    use DispatchesJobs,AuthorizesRequests;

    /**
     * The form data and the User model.
     *
     * @var array
     * @var User
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

        
        $this->authorize('create', new Inmueble);

        $direccion = $this->crearDireccion($rDireccion);
        $inmueble = $this->crearInmueble($rInmueble);
        $this->adjuntarFormatos($inmueble);
        $inmueblePadre = $this->crearInmueblePadre($rInmueblePadre, $direccion, $inmueble);

        $this->nominarOAsignarAdministrador($rPersona, $inmueble);
        $this->nominarOAsignarPropietario($rPersona, $inmueble);

        $this->user->notify(new InmuebleCreado($inmueble, $this->user));

        return $inmueblePadre;
    }

    /**
     * Adjuntar Formatos.
     *
     * @param  Inmueble $inmueble The Inmueble model.
     *
     * @return void
     */
    protected function adjuntarFormatos($inmueble)
    {
        $formatos = $this->data['formatos'];
        $inmueble->formatos()->attach($formatos);
    }

    /**
     * Crear Dirección.
     *
     * @param  DireccionRepository $repository The DireccionRepository object.
     *
     * @return Direccion
     */
    protected function crearDireccion(DireccionRepository $repository)
    {
        return $repository->create($this->data['idDireccion'])[1];
    }

    /**
     * Crear Inmueble.
     *
     * @param  InmuebleRepository $repository The InmuebleRepository object.
     *
     * @return Inmueble
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
     * Crear InmueblePadre.
     *
     * @param  InmueblePadreRepository $repository The InmueblePadreRepository object.
     * @param  Direccion               $direccion  The Direccion model.
     * @param  Inmueble                $inmueble   The Inmueble model.
     *
     * @return InmueblePadre
     */
    protected function crearInmueblePadre(InmueblePadreRepository $repository, Direccion $direccion, Inmueble $inmueble)
    {
        $inmueblePadre = $repository->create(array_merge($this->data['idInmueblePadre'],
            [
                'id_direccion' => $direccion->id,
                'id_inmueble' => $inmueble->id,
            ]
        ))[1];

        $inmueble->id_tabla_hija = $inmueblePadre->id;
        $inmueble->save();

        return $inmueblePadre;
    }

    /**
     * Nominar o Asignar Administrador Referente.
     *
     * @param  PersonaRepository $repository The PersonaRepository object.
     * @param  Inmueble          $inmueble   The Inmueble model.
     *
     * @return void
     */
    protected function nominarOAsignarAdministrador(PersonaRepository $repository, Inmueble $inmueble)
    {
	// idAdministradorReferente presente en el array?
	if (array_key_exists('idAdministradorReferente', $this->data)) {
	    $user = $this->user;

	    $id = $this->data['idAdministradorReferente'];

            // idAdministradorReferente no está vacío?
	    if ($id) {
                // idAdministradorReferente es distinto al id de la persona del usuario?
	        if ($id != $user->id_persona) {
	            $persona = $repository->findOrFail($id);

                    $this->dispatch(new NominarAdministradorReferenteParaInmueble($persona, $inmueble));
	        } else {
		    $persona = $user->idPersona;
		    $data = [];
		    if ($this->data['idInmueblePadre']['modalidad_propiedad'] === 'EN_CONDOMINIO') {
                        $data = array_only($this->data, ['dia_cobro_mensual', 'salario']);
		    }

                    $this->dispatch(new RelacionarAdministradorReferente($persona, $inmueble, $data));
		}
	    }
	}
    }

    /**
     * Nominar o Asingar Propietario Referente.
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
