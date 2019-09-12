<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\InmueblePersona;

use Caffeinated\Repository\Repositories\EloquentRepository;

class InmueblePersonaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = InmueblePersona::class;

    /**
     * @var array
     */
    public $tag = ['InmueblePersona'];

    /**
     * findPersonas.
     *
     * @return array
     */
    public function findPersonas()
    {
        return $this->filter()->sort()->get()
            ->map(
                function ($item) {
                    return $item->idPersona;
                }
            );
    }
}
