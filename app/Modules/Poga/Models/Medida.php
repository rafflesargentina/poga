<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'tipo',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medidas';
}
