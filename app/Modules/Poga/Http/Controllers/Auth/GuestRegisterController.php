<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\UseCases\RegistroUsuarioInvitado;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class GuestRegisterController extends Controller
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
     * Handle a guest registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $codigo_validacion
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, $codigo_validacion)
    {
        $this->validator($request->all())->validate();

        $data = $request->all();
        $user = User::where('codigo_validacion', $codigo_validacion)->firstOrFail();
        $user->loadMissing('idPersona.ciudades_cobertura', 'roles');

        dispatch(new RegistroUsuarioInvitado($data, $user));

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
            'email' => 'required|email',
            'id_persona.apellido' => 'required_if:enum_tipo_persona,FISICA',
            'id_persona.ciudades_cobertura' => 'array',
            'id_persona.fecha_nacimiento' => 'nullable|date',
            'id_persona.id_pais' => 'required',
            'id_persona.id_pais_cobertura' => 'required',
            'id_persona.nombre' => 'required',
            'id_persona.ci' => 'required',
            'password' => 'required|confirmed',
            'plan' => 'required_if:role_id,1',
            'role_id' => 'required',
            ]
        );
    }
}
