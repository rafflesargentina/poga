<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'id_departamento',
        'id_pais',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudades';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ciudades coberturas for the ciudad.
     */
    public function ciudades_cobertura()
    {
        return $this->hasMany(CiudadCobertura::class, 'id_ciudad');
    }

    /**
     * Get the departamento that owns the ciudad.
     */
    public function idDepartamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    /**
     * Get the pais that owns the ciudad.
     */
    public function idPais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }
}
