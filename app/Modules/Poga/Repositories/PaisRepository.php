<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Pais;

use Caffeinated\Repository\Repositories\EloquentRepository;

class PaisRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Pais::class;

    /**
     * @var array
     */
    public $tag = ['Pais'];
}
