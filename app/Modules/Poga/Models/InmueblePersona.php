<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InmueblePersona extends Pivot
{
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
    protected $with = 'idPersona';

    /**
     * Get the usuario creador that owns the inmueble.
     */
    public function idPersona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
