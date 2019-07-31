<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\InmueblePadre;

use Caffeinated\Repository\Repositories\EloquentRepository;

class InmueblePadreRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = InmueblePadre::class;

    /**
     * @var array
     */
    public $tag = ['InmueblePadre'];
}
