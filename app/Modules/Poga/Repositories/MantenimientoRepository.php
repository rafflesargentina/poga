<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Mantenimiento;

use Caffeinated\Repository\Repositories\EloquentRepository;

class MantenimientoRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Mantenimiento::class;

    /**
     * @var array
     */
    public $tag = ['Mantenimiento'];



    
}