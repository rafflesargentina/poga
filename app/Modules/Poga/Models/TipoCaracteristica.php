<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCaracteristica extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'nombre',
        'visibilidad_publica',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_caracteristica';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = 'caracteristicas';

    public function tipos_inmueble()
    {
        return $this->belongsToMany(TipoInmueble::class, 'tipo_inmueble_caracteristica_inmueble', 'id_tipo_inmueble', 'id_caracteristica_inmueble');
    }

    /**
     * Get all of the caracteristicas for the tipo caracteristica.
     */
    public function caracteristicas()
    {
        return $this->hasMany(Caracteristica::class, 'id_tipo_caracteristica');
    }
}
