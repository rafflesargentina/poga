<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class InmueblePadre extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cant_pisos',
        'comision_administrador',
        'divisible_en_unidades',
        'id_inmueble',
        'id_direccion',
        'modalidad_propiedad',
        'monto_fondo_reserva',
        'nombre',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inmuebles_padre';

    protected $with = ['idDireccion'];

    /**
     * Get the direccion that owns the inmueble padre.
     */
    public function idDireccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion');
    }

    /**
     * Get the inmueble that owns the inmueble padre.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the eventos for the inmueble padre.
     */
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_inmueble_padre');
    }

    /**
     * Get the unidades for the inmueble padre.
     */
    public function unidades()
    {
        return $this->hasMany(Unidad::class, 'id_inmueble_padre');
    }

    public function rentas()
    {
        return $this->idInmueble->rentas();
    }
}
