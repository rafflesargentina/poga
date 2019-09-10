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

    public function findPersonasActivas($whereConditions = [])
    {
        return $this->findWhere(array_merge($whereConditions, ['enum_estado' => 'ACTIVO']));
    }
}
