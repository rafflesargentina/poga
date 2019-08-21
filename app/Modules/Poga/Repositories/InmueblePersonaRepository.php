<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\InmueblePersona;

use Caffeinated\Repository\Repositories\EloquentRepository;

class InmueblePersonaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = InmueblePersona::class;

    /**
     * @var array
     */
    public $tag = ['InmueblePersona'];

    public function findPersonasActivas($idInmueblePadre)
    {
        return $this->whereHas('idInmueble', function($query) use($idInmueblePadre ) {
            return $query->where('inmuebles.enum_estado', 'ACTIVO')->where('enum_tabla_hija', 'INMUEBLES_PADRE')->where('id_tabla_hija', $idInmueblePadre);
        })->where('enum_estado', 'ACTIVO')->get();
    }
}
