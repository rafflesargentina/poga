<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\UnidadTrait;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use UnidadTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'persona_id_administrador_referente',
        'persona_id_inquilino_referente',
        'persona_id_propietario_referente',
        'nombre_y_apellidos_administrador_referente',
        'nombre_y_apellidos_inquilino_referente',
        'nombre_y_apellidos_propietario_referente',
        'tipo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'solicitud_directa_inquilinos' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area',
        'area_estacionamiento',
        'id_formato_inmueble',
        'id_inmueble',
        'id_inmueble_padre',
        'id_medida',
        'piso',
        'numero',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unidades';

    protected $with = ['idInmueble'];

    /**
     * Get the inmueble that owns the unidad.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the inmueble padre that owns the unidad.
     */
    public function idInmueblePadre()
    {
        return $this->belongsTo(InmueblePadre::class, 'id_inmueble_padre');
    }

    /**
     * Get the medida that owns the unidad.
     */
    public function idMedida()
    {
        return $this->belongsTo(Medida::class, 'id_medida');
    }
}
