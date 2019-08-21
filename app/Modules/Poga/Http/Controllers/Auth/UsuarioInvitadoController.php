<?php

namespace Raffles\Modules\Poga\Http\Controllers\Auth;

use Raffles\Modules\Poga\Http\Controllers\Controller;
use Raffles\Modules\Poga\Repositories\UserRepository;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class UsuarioInvitadoController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new UsuarioInvitadoController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request, $codigo_validacion)
    {
        $user = $this->repository->findBy('codigo_validacion', $request->codigo_validacion);

        if (!$user) {
            abort(404);
        }

        return $this->validSuccessJsonResponse('Success', $user);
    }
}
