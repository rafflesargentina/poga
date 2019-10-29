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
	'banco',    
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
     * Get the pagare record associated with the factura.
     */
    public function pagare()
    {
        return $this->hasOne(Pagare::class);
    }
}
