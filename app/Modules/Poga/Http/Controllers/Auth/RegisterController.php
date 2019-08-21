<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Models\{ Persona, User };
use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Notifications\UsuarioRegistrado;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use FormatsValidJsonResponses, RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
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
            'ciudadesCobertura' => 'array',
            'email' => 'required|email',
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
