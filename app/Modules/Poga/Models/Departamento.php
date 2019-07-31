<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'id_pais',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departamento';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ciudades for the departamento.
     */
    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'id_ciudad');
    }

    /**
     * Get the pais that owns the departamento.
     */
    public function idPais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }
}
