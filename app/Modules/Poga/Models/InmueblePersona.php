<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Filters\InmueblePersonaFilters;
use Raffles\Modules\Poga\Sorters\InmueblePersonaSorters;

use Illuminate\Database\Eloquent\Relations\Pivot;
use RafflesArgentina\FilterableSortable\FilterableSortableTrait;

class InmueblePersona extends Pivot
{
    use FilterableSortableTrait;

    /**
     * The associated query filters.
     *
     * @var InmueblePersonaFilters
     */
    protected $filters = InmueblePersonaFilters::class;

    /**
     * The associated query sorters.
     *
     * @var InmueblePersonaSorters
     */
    protected $sorters = InmueblePersonaSorters::class;

    /**
     * The table associated with the pivot.
     *
     * @var string
     */
    protected $table = 'inmueble_persona';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idPersona', 'idUnidad'];

    /**
     * Get the inmueble that own the inmueble persona.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the inmueble padre that owns the renta.
     */
    public function idInmueblePadre()
    {
        return $this->idUnidad->idInmueblePadre() ?: $this->idInmueble->idInmueblePadre();
    }

    /**
     * Get the persona that own the inmueble persona.
     */
    public function idPersona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    /**
     * Get the unidad that own the inmueble persona.
     */
    public function idUnidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad', 'id_inmueble');
    }
}
