<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmueblePersonaRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarInmueblePersona, CrearInmueblePersona, BorrarInmueblePersona };

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class PersonaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePersonaRepository object.
     *
     * @var InmueblePersonaRepository
     */
    protected $repository;

    /**
     * Create a new PersonaController instance.
     *
     * @param InmueblePersonaRepository $repository The InmueblePersonaRepository object.
     *
     * @return void
     */
    public function __construct(InmueblePersonaRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate(
            [
            'idInmueblePadre' => 'required',
            ]
        );

        $items = $this->repository->findPersonas();

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'enum_rol' => 'required',
            'id_inmueble' => 'required',
            'id_persona.apellido' => 'required_if:id_persona.enum_tipo_persona,FISICA',
            'id_persona.ci' => 'required_if:enum_tipo_persona,FISICA',
            'id_persona.enum_tipo_persona' => 'required',
            'id_persona.mail' => [
            'required_if:invitar,1',
                function ($attribute, $value, $fail) use ($request) {
                    $count = $this->repository
                        ->whereHas(
                            'idPersona', function ($query) use ($value) {
                                $query->where('mail', $value);
                            }
                        )
                        ->where('personas.enum_estado', 'ACTIVO')
                        ->where('enum_rol', $request->enum_rol)
                    ->count();
                    if ($count > 0) {
                        $fail('Ya existe una persona activa registrada con ese email para el rol seleccionado.');
                    }
                },
            ],
            'id_persona.nombre' => 'required',
            'id_persona.ruc' => 'required_if:id_persona.enum_tipo_persona,JURIDICA',
            'invitar' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $inmueblePersona = $this->dispatchNow(new CrearInmueblePersona($data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePersona);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
        $model->loadMissing('idPersona');

        return $this->validSuccessJsonResponse('Success', $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
        $model->loadMissing('idPersona.user');

        if ($model->idPersona->user) {
            $message = 'No es posibile actualizar una persona con usuario registrado.';
            return $this->validUnprocessableEntityJsonResponse(new MessageBag(), $message);
        }
        
        $request->validate(
            [
            'enum_rol' => 'required',
            'id_persona.apellido' => 'required_if:enum_tipo_persona,FISICA',
            'id_persona.mail' => [
            'required_if:invitar,1',
                function ($attribute, $value, $fail) use ($request) {
                    $count = $this->repository
                        ->whereHas(
                            'idPersona', function ($query) use ($value) {
                                $query->where('mail', $value);
                            }
                        )
                        ->where('personas.enum_estado', 'ACTIVO')
                        ->where('enum_rol', $request->enum_rol)
                        ->count();
                    if ($count > 0) {
                        $fail('Ya existe una persona activa registrada con ese email para el rol seleccionado.');
                    }
                },
            ],
            'id_persona.ci' => 'required_if:id_persona.enum_tipo_persona,FISICA',
            'id_persona.enum_tipo_persona' => 'required',
            'id_persona.nombre' => 'required',
            'id_persona.ruc' => 'required_if:id_persona.enum_tipo_persona,JURIDICA',
            'invitar' => 'required',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $inmueblePersona = $this->dispatchNow(new ActualizarInmueblePersona($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePersona);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);
        $model->loadMissing('idPersona.user');

        if ($model->idPersona->user) {
            $message = 'No es posibile borrar una persona con usuario registrado.';
            return $this->validUnprocessableEntityJsonResponse(new MessageBag(), $message);
        }

        $user = $request->user('api');
        $inmueblePersona = $this->dispatchNow(new BorrarInmueblePersona($model, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePersona);
    }
}
