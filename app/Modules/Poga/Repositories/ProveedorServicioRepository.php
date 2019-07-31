<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\ProveedorServicio;

use Caffeinated\Repository\Repositories\EloquentRepository;

class ProveedorServicioRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = ProveedorServicio::class;

    /**
     * @var array
     */
    public $tag = ['ProveedorServicio'];
}
