<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\PersonaRepository;
use Raffles\Modules\Poga\UseCases\{ ActualizarPersona, CrearPersona, BorrarPersona };

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class PersonaController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The PersonaRepository object.
     *
     * @var PersonaRepository $persona
     */
    protected $repository;

    /**
     * Create a new PersonaController instance.
     *
     * @param PersonaRepository $repository The PersonaRepository object.
     *
     * @return void
     */
    public function __construct(PersonaRepository $repository)
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
        $newQuery = $this->repository->newQuery();

        $enumRol = $request->enum_rol;
        if ($enumRol) {
            $newQuery->whereHas('idPersona', function($query) use($enumRol) {
                $query->where('enum_rol', $enumRol);
            });
        }

        $items = $newQuery->get()->pluck('idPersona');

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
            'apellido' => 'required_if:enum_tipo_persona,FISICA',
            'mail' => 'required|unique:personas,mail',
            'ci' => 'required_if:enum_tipo_persona,FISICA',
            'enum_tipo_persona' => 'required',
            'id_inmueble' => 'required',
            'nombre' => 'required',
            'ruc' => 'required_if:enum_tipo_persona,JURIDICA',
        ]);

        $data = $request->all();
        $user = $request->user('api');
        $persona = dispatch(new CrearPersona($data, $user));

        return $this->validSuccessJsonResponse('Success', $persona);
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

        $model->loadMissing('inmuebles');

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
            'apellido' => 'required_if:enum_tipo_persona,FISICA',
            'mail' => [
                'required',
                Rule::unique('personas')->ignore($id)
            ],
            'ci' => 'required_if:enum_tipo_persona,FISICA',
            'enum_tipo_persona' => 'required',
            'nombre' => 'required',
            'ruc' => 'required_if:enum_tipo_persona,JURIDICA',
        ]);

        $model = $this->repository->findOrFail($id);
        $data = $request->all();
        $user = $request->user('api');

        $persona = dispatch(new ActualizarPersona($model, $data, $user));

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
            $persona = $this->dispatch(new BorrarPersona($model, $request->user('api')));
        }

        return $this->validSuccessJsonResponse('Success', $persona);
    }
}
