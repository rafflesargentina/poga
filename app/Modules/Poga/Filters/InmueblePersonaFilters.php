<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters;

class InmueblePersonaFilters extends BaseFilters
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
        return $this->builder->where('inmueble_persona.enum_estado', $query);
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
        return $this->builder->where('enum_rol', $query);
    }

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
        );
    }
}
