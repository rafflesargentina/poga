<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Persona, User };
use Raffles\Modules\Poga\Notifications\PersonaCreada;
use Raffles\Modules\Poga\Repositories\{ InmueblePersonaRepository, PersonaRepository, RoleRepository, UserRepository };

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearInmueblePersona
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
     * @param PersonaRepository         $repository       The PersonaRepository object.
     * @param InmueblePersonaRepository $rInmueblePersona The InmueblePersonaRepository object.
     * @param UserRepository            $rUser            The UserRepository object.
     * @param RoleRepository            $rRole            The RoleRepository object.
     *
     * @return void
     */
    public function handle(PersonaRepository $repository, InmueblePersonaRepository $rInmueblePersona, UserRepository $rUser, RoleRepository $rRol)
    {
        $persona = $this->crearPersona($repository);
        $inmueblePersona = $this->crearInmueblePersona($persona, $rInmueblePersona);
        $user = $this->crearUsuario($persona, $rUser);

        if ($user) {
            $this->adjuntarRoles($user, $rRol);
        }

        return $inmueblePersona;
    }

    /**
     * @param RoleRepository $rRol The RolRepository object.
     * @param User           $user The User model.
     *
     * @return User
     */
    protected function adjuntarRoles(User $user, RoleRepository $repository)
    {
\Log::info("ASDASD");
        $role = $repository->findBy('slug', strtolower($this->data['enum_rol']));

        $user->roles()->attach($role);
        $user->role_id = $role->id;
        $user->save();

        return $user;
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     */
    protected function crearPersona(PersonaRepository $repository)
    {
        return $repository->create(array_merge($this->data['id_persona'],
            [
                'enum_estado' => 'ACTIVO',
                'id_usuario_creador' => $this->user->id,
            ]
        ))[1];
    }


    /**
     * @param Persona $persona
     */
    protected function crearInmueblePersona(Persona $persona, InmueblePersonaRepository $rInmueblePersona)
    {
        return $rInmueblePersona->create(['enum_estado' => 'ACTIVO', 'enum_rol' => $this->data['enum_rol'], 'id_inmueble' => $this->data['id_inmueble'], 'id_persona' => $persona->id])[1];
    }

    /**
     * @param Persona        $persona    The Persona model.
     * @param UserRepository $repository The UserRepository object.
     */
    protected function crearUsuario(Persona $persona, UserRepository $repository)
    {
        if ($this->data['invitar'] && !$persona->user) {
            $user = $repository->create([
                'codigo_validacion' => str_random(),
                'email' => $this->data['id_persona']['mail'],
                'first_name' => $persona->nombre,
                'id_persona' => $persona->id,
                'last_name' => $persona->apellido,
            ])[1];

            $p = $user->idPersona;

            $user->notify(new PersonaCreada($p));

            return $user;
        }
    }
}
