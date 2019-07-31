<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Unidad;

use Caffeinated\Repository\Repositories\EloquentRepository;

class UnidadRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Unidad::class;

    /**
     * @var array
     */
    public $tag = ['Unidad'];
}
