<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ InmueblePersona, Persona, User };
use Raffles\Modules\Poga\Notifications\InvitacionCreada;
use Raffles\Modules\Poga\Repositories\{ InmueblePersonaRepository, PersonaRepository, RoleRepository, UserRepository };

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ActualizarInmueblePersona
{
    use DispatchesJobs,AuthorizesRequests;

    /**
     * The InmueblePersona and User model.
     *
     * @var InmueblePersona
     * @var User
     */
    protected $inmueblePersona, $user;

    /**
     * The form data.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param InmueblePersona $inmueblePersona The InmueblePersona model.
     * @param array           $data            The form data.
     * @param User            $user            The User model.
     *
     * @return void
     */
    public function __construct(InmueblePersona $inmueblePersona, $data, User $user)
    {
        $this->inmueblePersona = $inmueblePersona;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param PersonaRepository         $repository       The PersonaRepository object.
     * @param InmueblePersonaRepository $rInmueblePersona The InmueblePersonaRepository object.
     * @param UserRepository            $rUser            The UserRepository object.
     * @param RoleRepository            $rRol             The RolRepository object.
     *
     * @return void
     */
    public function handle(PersonaRepository $repository, InmueblePersonaRepository $rInmueblePersona, UserRepository $rUser, RoleRepository $rRol)
    {
        $persona = $this->actualizarPersona($repository);
        $user = $this->crearUsuario($persona, $rUser);

        if ($user) {
            $this->adjuntarRoles($user, $rRol);
        }

        return $this->inmueblePersona;
    }

    /**
     * Adjuntar roles.
     *
     * @param RoleRepository $rRol The RolRepository object.
     * @param User           $user The User model.
     *
     * @return User
     */
    protected function adjuntarRoles(User $user, RoleRepository $repository)
    {
       


        $role = $repository->findBy('slug', strtolower($this->data['enum_rol']));

        $user->roles()->attach($role);
        $user->role_id = $role->id;
        $user->save();

        return $user;
    }

    /**
     * Actualizar Persona.
     *
     * @param PersonaRepository $repository The PersonaRepository object.
     *
     * @return Persona
     */
    protected function actualizarPersona(PersonaRepository $repository)
    {
        return $repository->update($this->inmueblePersona->id_persona, $this->data['id_persona'])[1];
    }

    /**
     * Crear Usuario.
     *
     * @param UserRepository $repository The UserRepository object.
     *
     * @return User|void
     */
    protected function crearUsuario(Persona $persona, UserRepository $repository)
    {

        if ($this->data['invitar'] && !$persona->user) {
            $user = $repository->create(
                [
                'codigo_validacion' => str_random(),
                'email' => $this->data['id_persona']['mail'],
                'first_name' => $persona->nombre,
                'id_persona' => $persona->id,
                'last_name' => $persona->apellido,
                ]
            )[1];

            $user->notify(new InvitacionCreada($user->idPersona));

            return $user;
        }
    }
}
