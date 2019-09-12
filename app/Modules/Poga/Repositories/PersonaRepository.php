<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Persona;

use Caffeinated\Repository\Repositories\EloquentRepository;

class PersonaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Persona::class;

    /**
     * @var array
     */
    public $tag = ['Persona'];

    /**
     * findPersonas.
     *
     * @return array
     */
    public function findPersonas()
    {
        return $this->filter()->sort()->get()->toArray();
    }
}
