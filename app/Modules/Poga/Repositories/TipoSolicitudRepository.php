<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\TipoSolicitud;

use Caffeinated\Repository\Repositories\EloquentRepository;

class TipoSolicitudRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = TipoSolicitud::class;

    /**
     * @var array
     */
    public $tag = ['TipoSolicitud'];
}
