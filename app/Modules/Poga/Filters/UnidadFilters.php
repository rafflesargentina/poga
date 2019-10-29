<?php

namespace Raffles\Modules\Poga\Filters;

use RafflesArgentina\FilterableSortable\BaseFilters;

class UnidadFilters extends BaseFilters
{
    /**
     * Exclusiones personalizadas.
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function excluir($query)
    {
	switch ($query) {
	// No trae unidades con contratos de renta pendientes.
	case 'rentas_activas_o_pendientes':
	    return $this->builder->whereHas('idInmueble', function($inmueble) {
	        $inmueble->whereDoesntHave('rentas', function($renta) {
	            $renta->whereIn('rentas.enum_estado', ['ACTIVO', 'PENDIENTE']);
		});
		$inmueble->orDoesntHave('rentas');
            });
	}
    }
}
