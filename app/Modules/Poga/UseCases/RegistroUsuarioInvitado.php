<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Persona, User };
use Raffles\Modules\Poga\Notifications\UsuarioRegistrado;
use Raffles\Modules\Poga\Repositories\{ PersonaRepository, UserRepository };

use Illuminate\Foundation\Bus\DispatchesJobs;

class RegistroUsuarioInvitado
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
     * @param UserRepository    $rUser      The UserRepository object.
     * @param PersonaRepository $repository The PersonaRepository object.
     *
     * @return void
     */
    public function handle(UserRepository $rUser, PersonaRepository $rPersona)
    {
        $user = $this->actualizarUsuario($rUser);
        $this->actualizarPersona($rPersona, $user);
        $this->adjuntarRoles($user);
        $this->crearCiudadesCobertura($user->idPersona);
        $this->blanquearCodigoValidacion($user);

        $user->notify(new UsuarioRegistrado($user));

        return $user;
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param User              $user       The User model.
     *
     * @return Persona
     */
    protected function actualizarPersona(PersonaRepository $repository, User $user)
    {
        return $repository->update($user->idPersona,
            array_merge(['enum_estado' => 'ACTIVO', 'mail' => $this->data['email']], $this->data['id_persona'])
        )[1];
    }

    /**
     * @param UserRepository $repository The UserRepository object.
     *
     * @return User
     */
    protected function actualizarUsuario(UserRepository $repository)
    {
        return $repository->update($this->user,
            [
            'email' => $this->data['email'],
            'first_name' => $this->data['id_persona']['nombre'],
            'last_name' => $this->data['id_persona']['apellido'],
            'password' => $this->data['password'],
            ]
        )[1];
    }

    /**
     * @param User $user The User model.
     *
     * @return User
     */
    protected function adjuntarRoles(User $user)
    {
        $role = $this->data['role_id'];
        $user->roles()->attach($role);

        return $user;
    }

    /**
     * @param Persona $persona The Persona model.
     */
    protected function crearCiudadesCobertura(Persona $persona)
    {
        foreach ($this->data['id_persona']['ciudades_cobertura'] as $ciudadId) {
            $persona->ciudades_cobertura()->create(['enum_estado' => 'ACTIVO', 'id_ciudad' => $ciudadId, 'role_id' => $this->data['role_id']]);
        }
    }

    /**
     * @param User $user The User model.
     *
     * @return User
     */
    protected function blanquearCodigoValidacion(User $user)
    {
        $user->codigo_validacion = null;
        $user->save();

        return $user;
    }
}
