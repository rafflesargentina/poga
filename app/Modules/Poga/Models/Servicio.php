<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'id',
        'nombre',
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
    protected $table = 'servicios';

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
     * Get the inmuebles for the pais.
     */
    public function inmuebles()
    {
        return $this->hasMany(Inmueble::class);
    }

    /**
     * The proveedores that belong to the servicio.
     */
    public function proveedores()
    {
        return $this->hasMany(ProveedorServicio::class, 'id_servicio');
    }
}
