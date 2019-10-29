<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters;

class RoleFilters extends BaseFilters
{
    /**
     * Include certain roles by slug.
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function only($query)
    {
        return $this->builder->whereIn('slug', [$query]);
    }
}
