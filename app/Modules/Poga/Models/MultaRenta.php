<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MultaRenta extends Pivot
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_renta',
        'id_pagare',
        'mes',
        'anno'
    ];

    /**
     * The table associated with the pivot.
     *
     * @var string
     */
    protected $table = 'multas_rentas';

    
}
