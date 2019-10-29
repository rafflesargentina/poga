<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters as QueryFilters;

class BaseFilters extends QueryFilters
{
    /**
     * idInmueblePadre
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function idInmueblePadre($query)
    {
        return $this->builder->whereHas(
            'idInmueble', function ($q) use ($query) {
                $q->where('enum_tabla_hija', 'INMUEBLES_PADRE');
                $q->where('id_tabla_hija', $query);
            }
        )
        ->orWhereHas(
            'idUnidad', function ($q) use ($query) {
                $q->where('id_inmueble_padre', $query);
            }
        );
    }
}
