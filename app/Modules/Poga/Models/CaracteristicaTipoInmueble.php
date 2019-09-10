<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CaracteristicaTipoInmueble extends Pivot
{
    /**
     * The table associated with the pivot.
     *
     * @var string
     */
    protected $table = 'caracteristica_tipo_inmueble';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = 'idCaracteristica';

    /**
     * Get the usuario creador that owns the inmueble.
     */
    public function idCaracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'id_caracteristica');
    }
}
