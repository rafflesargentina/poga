<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Moneda;

use Caffeinated\Repository\Repositories\EloquentRepository;

class MonedaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Moneda::class;

    /**
     * @var array
     */
    public $tag = ['Moneda'];
}
