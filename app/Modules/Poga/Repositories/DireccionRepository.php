<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Direccion;

use Caffeinated\Repository\Repositories\EloquentRepository;

class DireccionRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Direccion::class;

    /**
     * @var array
     */
    public $tag = ['Direccion'];
}
