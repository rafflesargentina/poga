<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class CiudadCobertura extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'enum_rol',
        'id_ciudad',
        'id_persona',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudades_cobertura';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ciudad that owns the cobertura.
     */
    public function idCiudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudad');
    }

    /**
     * Get the persona that owns the cobertura.
     */
    public function idPersona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
