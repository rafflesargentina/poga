<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\RolFuncionalidad;

use Caffeinated\Repository\Repositories\EloquentRepository;

class RolFuncionalidadRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = RolFuncionalidad::class;

    /**
     * @var array
     */
    public $tag = ['RolFuncionalidad'];
}
