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
        'descripcion',
        'enum_clasificacion_pagare',    
        'enum_estado',
	'id_distribucion_expensa',    
        'id_factura',    
	'id_inmueble',
        'id_moneda',
	'id_persona_acreedora',
        'id_persona_deudora',
        'id_tabla',
        'id_tipo_pagare',
	'fecha_pagare',
        'fecha_vencimiento',
        'fecha_pago_a_confirmar',
        'fecha_pago_confirmado',
	'fecha_pago_real',
        'mes_a_pagar',
        'monto',
        'nro_comprobante',
	'pagado_fuera_sistema',
        'pagado_con_fondos_de',
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
    protected $with = ['idInmueble', 'IdMoneda','IdFactura', 'idPersonaAcreedora'];

    /**
     * Get the factura that owns the pagare.
     */
    public function idFactura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }
  
    /**
     * Get the inmueble that owns the pagare.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the moneda that owns the pagare.
     */
    public function idMoneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }

    /**
     * Get the persona acreedora that owns the pagare.
     */
    public function idPersonaAcreedora()
    {
        return $this->belongsTo(Persona::class, 'id_persona_acreedora');
    }

    /**
     * Get the persona deudora that owns the pagare.
     */
    public function idPersonaDeudora()
    {
        return $this->belongsTo(Persona::class, 'id_persona_deudora');
    }

    /**
     * Get the unidad that owns the pagare.
     */
    public function idUnidad()
    {
        return $this->belongsTo(Unidad::class, 'id_inmueble', 'id_inmueble');
    }
}
