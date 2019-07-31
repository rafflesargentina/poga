<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\TipoInmueble;

use Caffeinated\Repository\Repositories\EloquentRepository;

class TipoInmuebleRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = TipoInmueble::class;

    /**
     * @var array
     */
    public $tag = ['TipoInmueble'];
}
