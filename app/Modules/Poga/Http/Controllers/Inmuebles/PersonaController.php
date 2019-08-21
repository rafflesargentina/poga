<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmueblePersonaRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarInmueblePersona, CrearInmueblePersona, BorrarInmueblePersona };

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class PersonaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The PersonaRepository and InmueblePersonaRepository objects.
     *
     * @var InmueblePersonaRepository $repository
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
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'idInmueblePadre' => 'required',
        ]);

        $idInmueblePadre = $request->idInmueblePadre;

        $items = $this->repository->findPersonasActivas($idInmueblePadre)
            ->map(function($item) {
                return [
                    'apellido' => $item->idPersona->apellido,
                    'ci' => $item->idPersona->ci,
                    'id' => $item->id,
                    'nombre' => $item->idPersona->nombre,
                    'nombre_completo_y_apellidos' => $item->idPersona->nombre_completo_y_apellidos,
                    'rol' => $item->enum_rol,
                    'ruc' => $item->idPersona->ruc,
                    'telefono' => $item->idPersona->telefono,
                    'tipo_persona' => $item->idPersona->enum_tipo_persona,
                ];
            });

        return $this->validSuccessJsonResponse('Success', $items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'enum_rol' => 'required',
            'id_inmueble' => 'required',
            'id_persona.apellido' => 'required_if:id_persona.enum_tipo_persona,FISICA',
            'id_persona.ci' => 'required_if:enum_tipo_persona,FISICA',
            'id_persona.enum_tipo_persona' => 'required',
            'id_persona.mail' => 'required|unique:personas,mail',
            'id_persona.nombre' => 'required',
            'id_persona.ruc' => 'required_if:id_persona.enum_tipo_persona,JURIDICA',
        ]);

        $data = $request->all();
        $user = $request->user('api');

        $inmueblePersona = $this->dispatchNow(new CrearInmueblePersona($data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePersona);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_persona.apellido' => 'required_if:enum_tipo_persona,FISICA',
            'id_persona.mail' => [
                'required',
            ],
            'id_persona.ci' => 'required_if:id_persona.enum_tipo_persona,FISICA',
            'id_persona.enum_tipo_persona' => 'required',
            'id_persona.nombre' => 'required',
            'id_persona.ruc' => 'required_if:id_persona.enum_tipo_persona,JURIDICA',
        ]);

        $model = $this->repository->findOrFail($id);
        $data = $request->all();
        $user = $request->user('api');

        $persona = $this->dispatchNow(new ActualizarInmueblePersona($model, $data, $user));

        return $this->validSuccessJsonResponse('Success', $persona);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->repository->findOrFail($id);

        if ($request->idInmueblePadre) {
            $persona = null;
        } else {
            $persona = $this->dispatchNow(new BorrarPersona($model, $request->user('api')));
        }

        return $this->validSuccessJsonResponse('Success', $persona);
    }
}
