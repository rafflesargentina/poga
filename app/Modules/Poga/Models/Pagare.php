<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Pagare extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [     
          
            'id_inmueble',
            'id_persona_acreedora',
            'id_persona_adeudora',
            'monto',
            'id_moneda',
            'fecha_pagare',
            'fecha_vencimiento',
            'fecha_pago_a_confirmar',
            'fecha_pago_confirmado',
            'fecha_pago_real',
            'pagado_fuera_sistema',
            'id_factura',
            'enum_estado',
            'enum_clasificacion_pagare',
            'id_tabla',
            'id_distribucion_expensa',
            'id_tipo_pagare',
            'description',
            'mes_a_pagar',
            'pagado_con_fondos_de',
            'nro_comprobante',
    ];

   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagares';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idInmueble', 'idPersonaAcreedora','IdMoneda','IdFactura'];

  
    /**
     * Get the inmueble that owns the inmueble.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the inquilino that owns the pagare.
     */
    public function idPersonaAcreedora()
    {
        return $this->belongsTo(Persona::class, 'id_persona_acreedora');
    }

    /**
     * Get the inquilino that owns the pagare.
     */
    public function idPersonaAdeudora()
    {
        return $this->belongsTo(Persona::class, 'id_persona_adeudora');
    }

    /**
     * Get the inquilino that owns the renta.
     */
    public function idMoneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }

    /**
     * Get the factura that owns the renta.
     */
    public function idFactura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

  
}