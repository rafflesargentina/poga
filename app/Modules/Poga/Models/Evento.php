<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'enum_tipo_evento',
        'id_espacio',
        'id_inmueble',
        'fecha_fin',
        'fecha_inicio',
        'hora_fin',
        'hora_inicio',
        'id_usuario_creador',
        'nombre',
    ];

   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eventos';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = 'idUsuarioCreador';

    /**
     * Get the espacio that owns the evento.
     */
    public function idEspacio()
    {
        return $this->belongsTo(Espacio::class, 'id_espacio');
    }
  
    /**
     * Get the inmueble that owns the evento.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the usuario creador that owns the inmueble.
     */
    public function idUsuarioCreador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }

    /**
     * Get the invitados for the evento.
     */
    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'id_evento');
    }
}
