<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Servicio;

use Caffeinated\Repository\Repositories\EloquentRepository;

class ServicioRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Servicio::class;

    /**
     * @var array
     */
    public $tag = ['Servicio'];
}
