<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Medida;

use Caffeinated\Repository\Repositories\EloquentRepository;

class MedidaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Medida::class;

    /**
     * @var array
     */
    public $tag = ['Medida'];
}
