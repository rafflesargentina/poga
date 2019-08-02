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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicios';

    /**
     * Get the inmuebles for the servicio.
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
        return $this->belongsToMany(Proveedor::class, 'proveedor_servicio', 'id_proveedor', 'id_servicio');
    }
}
