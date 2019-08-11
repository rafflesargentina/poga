<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'codigo',
        'disponible_cobertura',
        'enum_estado',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paises';

    public $incrementing = false;

    /**
     * Get the ciudades for the pais.
     */
    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'id_pais');
    }

    /**
     * Get the departamentos for the pais.
     */
    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'id_pais');
    }

    /**
     * Get the personas for the pais.
     */
    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_pais');
    }
}
