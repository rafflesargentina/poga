<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\UserRepository;
use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class UserController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UnidadController instance.
     *
     * @param UserRepository $repository
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $codigo_validacion)
    {
        $model = $this->repository->findBy('codigo_validacion', $codigo_validacion);

        if (!$model) {
            abort(404);
        }

        return $this->validSuccessJsonResponse('Success', $model);
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
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
