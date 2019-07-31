<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Nominacion;

use Caffeinated\Repository\Repositories\EloquentRepository;

class NominacionRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Nominacion::class;

    /**
     * @var array
     */
    public $tag = ['Nominacion'];
}
