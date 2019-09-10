<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\UserRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class ProveedorController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The UserRepository object.
     *
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * Create a new InmuebleController instance.
     *
     * @param UserRepository $repository The UserRepository object.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
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
        $items = $this->repository->whereHas(
            'idPersona', function ($query) {
                $query->where('enum_estado', 'ACTIVO');
            }
        )->whereHas(
            'roles', function ($query) {
                $query->where('slug', 'PROVEEDOR');
            }
        )->get();

        $map = $items->map(
            function ($item) {
                return $item->idPersona;
            }
        );

        return $this->validSuccessJsonResponse('Success', $map);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
