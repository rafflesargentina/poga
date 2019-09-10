<?php

namespace Raffles\Modules\Poga\Models;


use Illuminate\Database\Eloquent\Model;

class DistribucionExpensa extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_distribucion',
        'enum_estado',
        'enum_criterio',
        'id_inmueble_padre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distribuciones_expensas';
}

