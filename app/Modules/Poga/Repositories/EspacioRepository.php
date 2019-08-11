<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Espacio;

use Caffeinated\Repository\Repositories\EloquentRepository;

class EspacioRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Espacio::class;

    /**
     * @var array
     */
    public $tag = ['Espacio'];

    public function findEspacios($id_inmueble_padre)
    {
        $items = $this->whereHas(
            'idInmueble', function ($query) use ($id_inmueble_padre) { 
                return $query->where('enum_tabla_hija', 'INMUEBLES_PADRE')->where('id_tabla_hija', $id_inmueble_padre);
            }
        )->where('enum_estado', 'ACTIVO')->get();

        return $items;
    }
}
