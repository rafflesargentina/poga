<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_medio_pago',
        'fecha_pagado',
        'nro_operacion',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facturas';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
