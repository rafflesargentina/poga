<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'formato',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formatos';

    /**
     * The inmuebles that belong to the formato.
     */
    public function inmuebles()
    {
        return $this->belongsToMany(Inmueble::class, 'formato_inmueble', 'id_formato', 'id_inmueble');
    } 
}
