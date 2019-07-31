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
        'divisible_en_unidades',
        'dia_mes_pago',
        'dias_multa',
        'enum_estado',
        'expensas',
        'fecha_alta',
        'fecha_fin',
        'fecha_finalizacion_contrato',
        'fecha_inicio',
        'garantia',
        'id',
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
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
}
