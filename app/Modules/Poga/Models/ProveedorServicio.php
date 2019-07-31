<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedorServicio extends Model
{
    /**
     * The table associated with the pivot.
     *
     * @var string
     */
    protected $table = 'proveedor_servicio';

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

    protected $with = [
        'idProveedor',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Get the proveedor that owns the user.
     */
    public function idProveedor()
    {
        return $this->belongsTo(Persona::class, 'id_proveedor');
    }
}
