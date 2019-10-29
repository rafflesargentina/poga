<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Filters\RoleFilters;
use Raffles\Modules\Poga\Sorters\RoleSorters;

use Caffeinated\Shinobi\Models\Role as Model;
use RafflesArgentina\FilterableSortable\FilterableSortableTrait;

class Role extends Model
{
    use FilterableSortableTrait;

    /**
     * The associated query filters.
     *
     * @var RoleFilters
     */
    protected $filters = RoleFilters::class;

    /**
     * The associated query sorters.
     *
     * @var RoleSorters
     */
    protected $sorters = RoleSorters::class;
}
