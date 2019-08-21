<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apellidos',
        'ci',
        'id_evento',
        'nombre',
        'observacion',
    ];

   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invitados';

    /**
     * Get the evento that owns the invitado.
     */
    public function idEvento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
