<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'id_tipo_caracteristica',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'caracteristicas';

    /**
     * The inmuebles that belong to the caracteristicas inmueble.
     */
    public function inmuebles()
    {
        return $this->belongsToMany(Inmueble::class, 'caracteristica_inmueble', 'id_inmueble', 'id_caracteristica');
    }

    /**
     * Get the tipo caracteristica that owns the caracteristica inmueble.
     */
    public function idTipoCaracteristica()
    {
        return $this->belongsTo(TipoCaracteristica::class, 'id_tipo_caracteristica');
    }

    /**
     * The caracteristicas inmueble that belong to the tipo inmueble.
     */
    public function tipos_inmueble()
    {
        return $this->belongsToMany(TipoInmueble::class, 'caracteristica_tipo_inmueble', 'id_caracteristica', 'id_tipo_inmueble');
    }
}
