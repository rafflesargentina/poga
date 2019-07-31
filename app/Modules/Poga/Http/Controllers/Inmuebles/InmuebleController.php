<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\InmueblePadreRepository;
use Raffles\Modules\Poga\UseCases\{ BorrarInmueble, CrearInmueble };

use Caffeinated\Shinobi\Models\Role;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class InmuebleController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The InmueblePadreRepository object.
     *
     * @var InmueblePadreRepository $inmueble
     */
    protected $repository;

    /**
     * Create a new InmuebleController instance.
     *
     * @param InmueblePadreRepository $repository The InmueblePadreRepository object.
     *
     * @return void
     */
    public function __construct(InmueblePadreRepository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate(
            $request, [
            'tipoListado' => 'required|in:DisponiblesAdministrar,MisInmuebles,Nominaciones,TodosInmuebles',
            'rol' => 'required_if:tipo_listado,Nominaciones'
            ]
        );

        $items = [];
        $user = $request->user('api');

        switch($request->tipoListado) {
        case 'DisponiblesAdministrar':
            $items = $this->repository->with(['unidades' => function($query) { return $query->doesntHave('idInmueble.idAdministradorReferente'); }])
                ->doesntHave('idInmueble.idAdministradorReferente')
                ->orDoesntHave('unidades.idInmueble.idAdministradorReferente')
                ->get();

            $map = $items->map(
                function ($item) {
                        $inmueble = $item->idInmueble;

                        return [
                        'cant_unidades' => $item->unidades->count(),
                        'direccion' => $inmueble->direccion,
                        'divisible_en_unidades' => $item->divisible_en_unidades,
                        'id' => $item->id,
                        'id_usuario_creador' => $inmueble->id_usuario_creador,
                        'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                        'nombre' => $item->nombre,
                        'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                        'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                        'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                        'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                        'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                        'tipo' => $inmueble->tipo,
                        ];
                }
            );
            break;

        case 'MisInmuebles':
            $user->idPersona->inmuebles->loadMissing('unidades');

            $items = $user->idPersona->inmuebles->where('enum_estado', 'ACTIVO');

            $map = $items->map(
                function ($item) {
                        return [
                        'cant_unidades' => $item->unidades->count(),
                        'direccion' => $item->direccion,
                        'divisible_en_unidades' => $item->idInmueblePadre->divisible_en_unidades,
                        'id' => $item->idInmueblePadre->id,
                        'id_usuario_creador' => $item->id_usuario_creador,
                        'inmueble_completo' => $item->idAdministradorReferente ? false : true,
                        'nombre' => $item->idInmueblePadre->nombre,
                        'nombre_y_apellidos_administrador_referente' => $item->nombre_y_apellidos_administrador_referente,
                        'nombre_y_apellidos_inquilino_referente' => $item->nombre_y_apellidos_inquilino_referente,
                        'nombre_y_apellidos_propietario_referente' => $item->nombre_y_apellidos_propietario_referente,
                        'persona_id_administrador_referente' => $item->persona_id_administrador_referente,
                        'persona_id_inquilino_referente' => $item->persona_id_inquilino_referente,
                        'persona_id_propietario_referente' => $item->persona_id_propietario_referente,
                        'tipo' => $item->tipo,
                        ];
                }
            );
                
            break;

        case 'Nominaciones':
            $role = Role::where('slug', $request->rol)->first();

            $user->idPersona->loadMissing('nominaciones.idInmueble.unidades');
            $items = $user->idPersona->nominaciones->where('role_id', $role->id);

            $map = $items->map(
                function ($item) {
                        $inmueble = $item->idInmueble;

                        return [
                        'cant_unidades' => $inmueble->unidades->count(),
                        'direccion' => $inmueble->direccion,
                        'divisible_en_unidades' => $item->divisible_en_unidades,
                        'id' => $inmueble->id_inmueble_padre,
                        'id_usuario_creador' => $inmueble->id_usuario_creador,
                        'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                        'nombre' => $inmueble->idInmueblePadre->nombre,
                        'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                        'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                        'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                        'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                        'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                        'tipo' => $inmueble->tipo,
                        ];
                }
            );
            break;

        case 'TodosInmuebles':
            $items = $this->repository->with('unidades')->get();

            $map = $items->map(
                function ($item) {
                        $inmueble = $item->idInmueble;

                        return [
                        'cant_unidades' => $item->unidades->count(),
                        'direccion' => $inmueble->direccion,
                        'divisible_en_unidades' => $item->divisible_en_unidades,
                        'id' => $item->id,
                        'id_usuario_creador' => $inmueble->id_usuario_creador,
                        'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                        'nombre' => $item->nombre,
                        'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                        'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                        'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                        'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                        'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                        'tipo' => $inmueble->tipo,
                        ];
                }
            );
            break;
        }

        return $this->validSuccessJsonResponse('Success', $map);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request, [
            'formatos' => 'required|array',
            'idDireccion.calle_principal' => 'required',
            'idDireccion.calle_secundaria' => 'required',
            'idDireccion.numeracion' => 'required',
            'idInmueble.id_tipo_inmueble' => 'required',
            'idInmueble.solicitud_directa_inquilinos' => 'required',
            'idInmueblePadre.nombre' => 'required',
            'idInmueblePadre.cant_pisos' => 'required',
            'idInmueblePadre.comision_administrador' => 'required',
            'idPropietarioReferente' => 'required|array',
            ]
        );

        $data = $request->all();
        $user = $request->user('api');
        $inmueblePadre = $this->dispatch(new CrearInmueble($data, $user));

        return $this->validSuccessJsonResponse('Success', $inmueblePadre);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $model = $this->repository->find($id);

        if (!$model) {
            abort(404);
        }

        return $this->validSuccessJsonResponse('Success', $model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $inmueble = $this->repository->find($id);
        $inmueble->update($request->all());

        $idInmueble = $request->idInmueble;

        $inmueble->idInmueble->update(
            [
            'solicitud_directa_inquilinos' => $idInmueble['solicitudDirectaInquilinos']
            ]
        ); 

        return $this->validSuccessJsonResponse('Success', $inmueble->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inmueblePadre = $this->repository->find($id);

        if (!$inmueblePadre) {
            abort(404);
        }

        $inmueble = $this->dispatch(new BorrarInmueble($inmueblePadre->idInmueble, $request->user('api')));

        return $this->validSuccessJsonResponse('Success');
    }
}
