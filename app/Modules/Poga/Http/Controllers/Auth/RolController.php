<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\RoleRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class RolController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * The RoleRepository object.
     *
     * @var RoleRepository $repository
     */
    protected $repository;

    /**
     * Create a new RolController instance.
     *
     * RoleRepository $repository The RoleRepository object.
     *
     * @return void
     */
    public function __construct(RoleRepository $repository)
    {
        $this->middleware('auth:api', ['except' => 'index']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('api');

        $roles = $user ? $user->roles : $this->repository->findAll(); 

        return $this->validSuccessJsonResponse('Success', $roles);
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
    public function destroy($id)
    {
        //
    }
}
