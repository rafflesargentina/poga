<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'id_inmueble',
        'nombre',
    ];

   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'espacios';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = 'idInmueble';

  
    /**
     * Get the inmueble that owns the inmueble.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }
}
