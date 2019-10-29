<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Renta;

use Caffeinated\Repository\Repositories\EloquentRepository;

class RentaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Renta::class;

    /**
     * @var array
     */
    public $tag = ['Renta'];

    /**
     * findRentas.
     *
     * @return array
     */
    public function findRentas()
    {
        $items = $this->with('idUnidad')->filter()->sort()->get()->toArray();

        return $items;
    }
}
