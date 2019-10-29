<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Filters\SolicitudFilters;
use Raffles\Modules\Poga\Sorters\SolicitudSorters;
use Raffles\Modules\Poga\Models\Traits\SolicitudTrait;

use Illuminate\Database\Eloquent\Model;
use RafflesArgentina\FilterableSortable\FilterableSortableTrait;

class Solicitud extends Model
{
    use FilterableSortableTrait, SolicitudTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'nombre_servicio',
        'nombre_y_apellidos_usuario_creador',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion_solicitud',
        'description_concluir',
        'enum_estado',
        'enum_tipo_solicitud',
        'fecha_fijada_respuesta',
        'id_proveedor',
        'id_servicio',
        'id_usuario_creador',
        'id_usuario_asigna',
    ];

    protected $filters = SolicitudFilters::class;

    protected $sorters = SolicitudSorters::class;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idServicio', 'idUsuarioCreador','idInmueble', 'idUnidad'];

    /**
     * Get the servicio that owns the solicitud.
     */
    public function idServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    /**
     * Get the usuario creador that owns the solicitud.
     */
    public function idUsuarioCreador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }

    /**
     * Get the inmueble that owns the solicitud.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the tipo solicitud that owns the solicitud.
     */
    public function idTipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'id_tipo_solicitud');
    }

    /**
     * Get the unidad that owns the solicitud.
     */
    public function idUnidad()
    {
        return $this->belongsTo(Unidad::class, 'id_inmueble', 'id_inmueble');
    }
}
