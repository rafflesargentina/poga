<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\TipoCaracteristica;

use Caffeinated\Repository\Repositories\EloquentRepository;

class TipoCaracteristicaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = TipoCaracteristica::class;

    /**
     * @var array
     */
    public $tag = ['TipoCaracteristica'];
}
