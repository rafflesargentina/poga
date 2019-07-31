<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Formato;

use Caffeinated\Repository\Repositories\EloquentRepository;

class FormatoRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Formato::class;

    /**
     * @var array
     */
    public $tag = ['Formato'];
}
