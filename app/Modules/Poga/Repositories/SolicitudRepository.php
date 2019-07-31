<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Solicitud;

use Caffeinated\Repository\Repositories\EloquentRepository;

class SolicitudRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Solicitud::class;

    /**
     * @var array
     */
    public $tag = ['Solicitud'];
}
