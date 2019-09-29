<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\ProveedorServicio;

use Caffeinated\Repository\Repositories\EloquentRepository;

class ProveedorServicioRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = ProveedorServicio::class;

    /**
     * @var array
     */
    public $tag = ['ProveedorServicio'];

    public function findMantenimientos($idInmueblePadre, $estado = 'ACTIVO')
    {
        return $this->whereHas('mantenimientos', function($query) use($idInmueblePadre, $estado) {
            $query->where('enum_estado', $estado)->whereHas('idInmueble', function($q) use($idInmueblePadre) {
                $q->where('id_inmueble_padre', $idInmueblePadre);
            });
	});
    }
}
