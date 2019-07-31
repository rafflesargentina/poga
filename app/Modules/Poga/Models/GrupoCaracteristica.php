<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoCaracteristica extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'enum_estado',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grupo_caracteristicas';
}
