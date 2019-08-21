<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\UserTrait;;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, ShinobiTrait, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'id_persona',
        'last_name',
        'password',
        'bloqueado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = 'idPersona';

    /**
     * Get the persona record associated with the user.
     */
    public function idPersona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    /**
     * Get the inmuebles for the usuario.
     */
    public function inmuebles()
    {
        return $this->hasMany(Inmueble::class, 'id_usuario_creador');
    }

    /**
     * Get the mantenimientos for the usuario.
     */
    public function mantenimientos()
    {
        return $this->hasManyThrough(Mantenimiento::class, ProveedorServicio::class, 'id_proveedor', 'id_proveedor_servicio');
    }

    /**
     * Get the nominaciones for the usuario.
     */
    public function nominaciones()
    {
        return $this->hasMany(Nominacion::class, 'usu_alta');
    }

    /**
     * Get the persona creadas for the usuario.
     */
    public function personas_creadas()
    {
        return $this->hasMany(Persona::class, 'id_usuario_creador');
    }

    /**
     * Get the proveedores servicio for the usuario.
     */
    public function proveedores_servicio()
    {
        return $this->hasManyThrough(ProveedorServicio::class, Persona::class, 'id_usuario_creador', 'id_proveedor');
    }
}
