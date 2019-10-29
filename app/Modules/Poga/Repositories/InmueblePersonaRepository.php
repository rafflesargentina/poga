<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\{ InmueblePersona, User };

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
        return $this->filter()->sort()->groupBy('id_persona')->get()
            ->map(
                function ($item) {
                    return $item->idPersona;
                }
            );
    }
}
