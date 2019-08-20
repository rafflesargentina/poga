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

    public function actualizarEstado($data){

        $pagare = Pagare::findOrFail($data['idPagare']);


        $pagare->update([
            'enum_estado' => $data['estado']
        ]);

        return $pagare;
     
    }


    
}