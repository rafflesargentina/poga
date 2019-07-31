<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Models\User;
use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('guest');
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

        $url = $this->getBaseUrl()."acceso/registro";
        $client = $this->getHttpClient();
        $response = $client->request(
            'POST', $url, ['query' => [
            'apellido' => $request->last_name,
            'ciudadesCobertura' => $request->coverage_cities,
            'correo' => $request->email,
            'direccion' => $request->address,
            'fechaNacimiento' => $request->birthdate,
            'idPais' => $request->country_id,
            'nombre' =>  $request->first_name,
            'numeroDocumento' => $request->document_number,
            'paisCovertura' => $request->coverage_country,
            'password' => $request->password,
            'plan' => $request->plan,
            'rolSeleccionado' => $request->role,
            'sexo' => $request->sex,
            'telefono' => $request->phone,
            'tipoPersona' => $request->person_type_id,
            ]]
        );

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            if (!$data['ok']) {
                $message = $data['response']['debugMessage'];
                return $this->validInternalServerErrorJsonResponse(new \Exception($message), $message);
            }

             return $this->validSuccessJsonResponse($data['ok'], $data['response'], $this->redirectPath());
        }
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
            'last_name' => 'required_if:person_type_id,FISICA',
            'coverage_cities' => 'array',
            'email' => 'required|email',
            'birthdate' => 'nullable|date',
            'country_id' => 'required',
            'first_name' => 'required',
            'document_number' => 'required',
            'password' => 'required|confirmed',
            'plan' => 'required_if:role,ADMINISTRADOR',
            'role' => 'required',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \Raffles\Models\User
     */
    protected function create(array $data)
    {
        return User::create(
            [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => $data['password'],
            ]
        );
    }
}
