<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\CaracteristicaInmueble;

use Caffeinated\Repository\Repositories\EloquentRepository;

class CaracteristicaInmuebleRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = CaracteristicaInmueble::class;

    /**
     * @var array
     */
    public $tag = ['CaracteristicaInmueble'];
}
