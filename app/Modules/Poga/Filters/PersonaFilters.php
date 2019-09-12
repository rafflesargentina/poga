<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters;

class PersonaFilters extends BaseFilters
{
    /**
     * enum_estado
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function enum_estado($query)
    {
        return $this->builder->where('personas.enum_estado', $query);
    }

    /**
     * enum_rol
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function enum_rol($query)
    {
        return $this->builder->whereHas(
            'inmuebles', function ($q) {
                $q->where('enum_rol', $query);
            }
        );
    }
}
