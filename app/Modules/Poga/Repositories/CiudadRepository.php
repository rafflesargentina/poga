<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Ciudad;

use Caffeinated\Repository\Repositories\EloquentRepository;

class CiudadRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Ciudad::class;

    /**
     * @var array
     */
    public $tag = ['Ciudad'];
}
