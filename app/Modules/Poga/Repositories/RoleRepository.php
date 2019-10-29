<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Role;

use Caffeinated\Repository\Repositories\EloquentRepository;

class RoleRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Role::class;

    /**
     * @var array
     */
    public $tag = ['Role'];
}
