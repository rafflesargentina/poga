<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\DireccionTrait;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use DireccionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'calle_principal',
        'calle_secundaria',
        'latitud',
        'longitud',
        'numeracion',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'direcciones';
}

