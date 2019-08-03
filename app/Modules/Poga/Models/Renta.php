<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comision_administrador',
        'dias_multa',
        'enum_estado',
        'expensas',
        'fecha_fin',
        'fecha_finalizacion_contrato',
        'fecha_inicio',
        'garantia',
        'id_inmueble',
        'id_inquilino',
        'id_moneda',
        'monto',
        'monto_descontado_garantia_finalizacion_contrato',
        'monto_multa_dia',
        'multa',
        'prim_comision_admin',
    ];

   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rentas';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idInmueble', 'idInquilino'];

  
    /**
     * Get the inmueble that owns the inmueble.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the inquilino that owns the renta.
     */
    public function idInquilino()
    {
        return $this->belongsTo(Persona::class, 'id_inquilino');
    }

    /**
     * Get the inquilino that owns the renta.
     */
    public function idMoneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }
}
