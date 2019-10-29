<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Filters\ProveedorServicioFilters;
use Raffles\Modules\Poga\Sorters\ProveedorServicioSorters;

use Illuminate\Database\Eloquent\Model;
use RafflesArgentina\FilterableSortable\FilterableSortableTrait;

class ProveedorServicio extends Model
{
    use FilterableSortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'id',
        'id_proveedor',
        'id_servicio',
    ];

    protected $filters = ProveedorServicioFilters::class;

    protected $sorters = ProveedorServicioSorters::class;

    /**
     * The table associated with the pivot.
     *
     * @var string
     */
    protected $table = 'proveedor_servicio';

    protected $with = [
	'idProveedor',
	'idServicio',
    ];

    /**
     * Get the proveedor that owns the proveedor servicio.
     */
    public function idProveedor()
    {
        return $this->belongsTo(Persona::class, 'id_proveedor');
    }

    /**
     * Get the servicio that owns the proveedor servicio.
     */
    public function idServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    /**
     * Get the mantenimientos for the proveedor servicio.
     */
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_proveedor_servicio');
    }
}
