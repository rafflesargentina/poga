<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Models\{ Persona, User };
use Raffles\Http\Controllers\Auth\RegisterController as Controller;
use Raffles\Modules\Poga\Notifications\UsuarioRegistrado;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RegisterController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        $user->loadMissing('roles');

        $user->notify(new UsuarioRegistrado($user));

        return $user;

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data, [
            'ciudadesCobertura' => 'required|array|min:1',
            'email' => 'required|email|unique:users,email',
            'enum_tipo_persona' => 'required',
            'idPersona.apellido' => 'required_if:enum_tipo_persona,FISICA',
            'idPersona.fecha_nacimiento' => 'nullable|date',
            'idPersona.id_pais' => 'required',
            'idPersona.id_pais_cobertura' => 'required',
            'idPersona.nombre' => 'required',
            'idPersona.ci' => 'required',
            'password' => 'required|confirmed',
            'plan' => 'required_if:role_id,1',
            'role_id' => 'required',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $persona = Persona::create(array_merge(['enum_estado' => 'ACTIVO', 'mail' => $data['email']], $data['idPersona']));

        $user = User::create(
            [
            'email' => $data['email'],
            'first_name' => $data['idPersona']['nombre'],
            'id_persona' => $persona->id,
            'last_name' => $data['idPersona']['apellido'],
            'password' => $data['password'],
            ]
        );

        foreach ($data['ciudadesCobertura'] as $ciudadId) {
            $persona->ciudades_cobertura()->create(['enum_estado' => 'ACTIVO', 'id_ciudad' => $ciudadId, 'role_id' => $data['role_id']]);
        }

        $role = $data['role_id'];
        $user->roles()->attach($role);

        return $user;
    }
}
