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
    //protected $with = ['caracteristicas', 'tipos_inmueble'];

    public function tipos_inmueble()
    {
        return $this->belongsToMany(TipoInmueble::class, 'caracteristica_tipo_inmueble', 'id_tipo_caracteristica', 'id_tipo_inmueble')
            ->withPivot(['enum_estado', 'id_grupo_caracteristica', 'id_tipo_caracteristica', 'enum_tipo_campo', 'espacio_comun']);
    }

    /**
     * Get all of the caracteristicas for the tipo caracteristica.
     */
    public function caracteristicas()
    {
        return $this->hasMany(CaracteristicaTipoInmueble::class, 'id_tipo_caracteristica');
    }
}
