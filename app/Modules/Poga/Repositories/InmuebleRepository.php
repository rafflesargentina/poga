<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Inmueble;

use Caffeinated\Repository\Repositories\EloquentRepository;

class InmuebleRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Inmueble::class;

    /**
     * @var array
     */
    public $tag = ['Inmueble'];
}
