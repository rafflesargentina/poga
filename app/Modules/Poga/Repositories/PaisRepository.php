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

    public function findActivos()
    {
        return $this->orderBy('nombre', 'asc')->findWhere(['enum_estado' => 'ACTIVO']);
    }

    public function findActivosConCobertura()
    {
        return $this->orderBy('nombre', 'asc')->findWhere(['disponible_cobertura' => '1', 'enum_estado' => 'ACTIVO']);
    }
}
