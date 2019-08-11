<?php

namespace Raffles\Modules\Poga\Models;

use Caffeinated\Shinobi\Models\Role;
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
        'id_ciudad',
        'id_persona',
        'role_id',
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

    /**
     * Get the role that owns the cobertura.
     */
    public function idRol()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
