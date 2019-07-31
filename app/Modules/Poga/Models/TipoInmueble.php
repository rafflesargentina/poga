<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class TipoInmueble extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cant_pisos_fija',
        'configurable_division_unidades',
        'descripcion',
        'enum_aplica_a',
        'enum_estado',
        'tipo',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_inmueble';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    //protected $with = 'caracteristicas_inmuebles';

    /**
     * The caracteristicas that belong to the tipo inmueble.
     */
    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'caracteristica_tipo_inmueble', 'id_caracteristica', 'id_tipo_inmueble');
    }

    /**
     * Get the inmuebles registrados for the tipo inmueble.
     */
    public function inmuebles()
    {
        return $this->hasMany(Inmueble::class, 'id_tipo_inmueble');
    }

    /**
     * Get the tipo caracteristica that owns the tipo inmueble.
     */
    public function tipos_caracteristica()
    {
        return $this->belongsToMany(TipoCaracteristica::class, 'tipo_inmueble_caracteristica_inmueble', 'id_tipo_inmueble', 'id_tipo_caracteristica');
    }
}
