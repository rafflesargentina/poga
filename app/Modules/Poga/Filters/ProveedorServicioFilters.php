<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters;

class ProveedorServicioFilters extends BaseFilters
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
        return $this->builder->where('proveedor_servicio.enum_estado', $query);
    }

    /**
     * id_proveedor
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function id_proveedor($query)
    {
        return $this->builder->where('id_proveedor', $query);
    }

    /**
     * id_servicio
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function id_servicio($query)
    {
        return $this->builder->where('id_servicio', $query);
    }
}
