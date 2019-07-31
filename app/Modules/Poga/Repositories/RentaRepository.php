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
}
