<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class SeleccionarRolController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new SeleccionarRolController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'rol' => 'required',
        ]);

        $user = $request->user('api');

        $role = $user->roles->where('slug', $request->rol)->first();
        $permissions = $role->permissions->pluck('slug') ?: [];

        $user->update(['role_id' => $role->id]);
        $user->loadMissing('roles');

        $data = [
            'permissions' => $permissions,
            'role' => $role,
            'token' => $user->accessToken,
        ];

        return $this->validSuccessJsonResponse('Success', $data);
    }
}
