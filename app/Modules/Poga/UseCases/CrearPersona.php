<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Persona, User };
use Raffles\Modules\Poga\Notifications\InvitacionCreada;
use Raffles\Modules\Poga\Repositories\{ PersonaRepository, RoleRepository, UserRepository };

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearPersona
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
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param UserRepository    $rUser      The UserRepository object.
     *
     * @return void
     */
    public function handle(PersonaRepository $repository, UserRepository $rUser, RoleRepository $rRol)
    {
        $persona = $this->crearPersona($repository);
        $this->adjuntarInmueble($persona);
        $user = $this->crearUsuario($persona, $rUser);
        $this->adjuntarRoles($user, $rRol);

        return $persona;
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     */
    protected function crearPersona(PersonaRepository $repository)
    {
        return $repository->create(array_merge($this->data,
            [
                'enum_estado' => 'ACTIVO',
                'id_usuario_creador' => $this->user->id,
            ]
        ))[1];
    }


    /**
     * @param Persona $persona
     */
    protected function adjuntarInmueble(Persona $persona)
    {
        return $persona->inmuebles()->attach($this->data['id_inmueble'], ['enum_estado' => 'ACTIVO', 'enum_rol' => $this->data['enum_rol']]);
    }

    /**
     * @param RoleRepository $rRol The RolRepository object.
     * @param User           $user The User model.
     *
     * @return User
     */
    protected function adjuntarRoles(User $user, RoleRepository $rRol)
    {
        $role = $rRol->findBy('slug', strtolower($this->data['enum_rol']));

        $user->roles()->attach($role);
        $user->role_id = $role->id;
        $user->save();

        return $user;
    }

    /**
     * @param UserRepository $repository The UserRepository object.
     */
    protected function crearUsuario(Persona $persona, UserRepository $repository)
    {
        if ($this->data['invitar'] && !$persona->user) {
            $user = $repository->create(
                [
                    'codigo_validacion' => str_random(),
                    'email' => $this->data['mail']
                ]
            )[1];

            $persona->idUsuarioCreador()->associate($user);
            $user->idPersona()->associate($persona);

            $user->notify(new InvitacionCreada($persona, $user));
        }
    }
}
