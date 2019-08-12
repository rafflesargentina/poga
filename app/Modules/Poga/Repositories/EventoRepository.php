<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Evento;

use Caffeinated\Repository\Repositories\EloquentRepository;

class EventoRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Evento::class;

    /**
     * @var array
     */
    public $tag = ['Evento'];

    public function findVisitas($idInmueblePadre)
    {
        return $this->whereHas('idInmueble', function($query) use($idInmueblePadre ) {
            // Pueden ser Inmuebles o Unidades
            return $query->where('id_tabla_hija', $idInmueblePadre);
        })->where('enum_estado', 'ACTIVO')->where('enum_tipo_evento', 'VISITA')->get();
    }
}
