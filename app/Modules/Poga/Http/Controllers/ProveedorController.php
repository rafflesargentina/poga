<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use Raffles\Modules\Poga\Repositories\UserRepository;
use Raffles\Modules\Poga\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RafflesArgentina\ResourceController\Traits\FormatsValidJsonResponses;

class ProveedorController extends Controller
{
    use FormatsValidJsonResponses;

    /**
     * Create a new ProveedorController instance.
     *
     * @param UserrRepository $repository The UserRepository object.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
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
}
