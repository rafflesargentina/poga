<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitud extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_solcitud';

    /**
     * Get the solicitudes for the tipo solicitud.
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_tipo_solicitud');
    }
}
