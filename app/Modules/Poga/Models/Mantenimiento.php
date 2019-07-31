<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\MantenimientoTrait;
use Raffles\Modules\Poga\Models\Traits\SolicitudTrait;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use MantenimientoTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'costo',
        'frecuencia',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_dias_semana',
        'enum_estado',
        'enum_se_repite',
        'fecha_hora_programado',
        'fecha_terminacion_repeticion',
        'id_inmueble',
        'id_moneda',
        'id_proveedor_servicio',
        'id_inmueble_caracteristica_inmueble',
        'monto',
        'repetir',
        'repetir_cada',
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
    protected $table = 'mantenimientos';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idInmueble', 'idMoneda'];

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
     * Get the moneda servicio that owns the mantenimiento.
     */
    public function idMoneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }

    /**
     * Get the inmueble that owns the mantenimiento.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }


    /**
     * Get the proveedor servicio that owns the mantenimiento.
     */
    public function idProveedorServicio()
    {
        return $this->belongsTo(ProveedorServicio::class, 'id_servicio');
    }
}
