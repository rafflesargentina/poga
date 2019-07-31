<?php

namespace Raffles\Modules\Poga\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenInmueble extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'enum_estado',
        'id_inmueble',
        'imagen',
        'principal',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'imagenes_inmueble';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

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
     * Get the imagenes inmueble for the inmueble.
     */
    public function imagenes_inmueble()
    {
        return $this->hasMany(ImagenInmueble::class, 'id_inmueble');
    }
}
