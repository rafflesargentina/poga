<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Pagare;

use Caffeinated\Repository\Repositories\EloquentRepository;

class PagareRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Pagare::class;

    /**
     * @var array
     */
    public $tag = ['Pagare'];

    public function fetch($id_inmueble_padre){

        $items = $this->whereHas('idInmueble', function($query) use ($id_inmueble_padre) { return $query->where('id_tabla_hija', $id_inmueble_padre)->where('enum_tabla_hija', 'INMUEBLES_PADRE'); })
            ->where('enum_estado', '!=', 'INACTIVO')
            ->get();

        return $items;
    }



    public function actualizarEstado($pagare,$estado){

       
        $pagare->update([
            'enum_estado' => $estado
        ]);
        return $pagare;
     
    }


    
}