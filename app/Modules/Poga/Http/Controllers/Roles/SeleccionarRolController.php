<?php

namespace Raffles\Modules\Poga\Http\Controllers\Roles;

use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class SeleccionarRolController extends Controller
{
    use FormatsValidJsonResponses;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request)
    {
        $user = $request->user('api');
        $user->loadMissing('roles');

        $role = $user->roles->where('slug', $request->rol)->first();
        $permissions = $role->permissions->pluck('slug') ?: [];

        $data = [
            'permissions' => $permissions,
            'role' => $role,
            'token' => $user->accessToken,
        ];

        return $this->validSuccessJsonResponse('Success', $data);
    }
}
