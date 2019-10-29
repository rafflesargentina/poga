<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Solicitud;

use Caffeinated\Repository\Repositories\EloquentRepository;

class SolicitudRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Solicitud::class;

    /**
     * @var array
     */
    public $tag = ['Solicitud'];

    public function listar()
    {
        $items = $this->filter()->sort()->get();

	return $items;
    }

    /**
     * Map the items collection.
     * 
     * @param Collection $items
     */
    protected function map(Collection $items)
    {
        return $items->map(function($item) {
            return [

	    ];
	});
    }
}
