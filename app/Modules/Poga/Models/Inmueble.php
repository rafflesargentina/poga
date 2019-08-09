<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\InmuebleTrait;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    use InmuebleTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'direccion',
        'persona_id_administrador_referente',
        'persona_id_inquilino_referente',
        'persona_id_propietario_referente',
        'nombre_y_apellidos_administrador_referente',
        'nombre_y_apellidos_inquilino_referente',
        'nombre_y_apellidos_propietario_referente',
        'tipo',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enum_estado',
        'enum_tabla_hija',
        'id_tabla_hija',
        'id_tipo_inmueble',
        'id_usuario_creador',
        'solicitud_directa_inquilinos',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inmuebles';

    protected $with = ['idInmueblePadre', 'idTipoInmueble'];

    /**
     * Get the administradores for the inmueble.
     */
    public function administradores()
    {
        return $this->hasMany(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'ADMINISTRADOR');
    }

    /**
     * The caracteristicas inmueble that belong to the inmueble.
     */
    public function caracteristicas_inmueble()
    {
        return $this->belongsToMany(CaracteristicaInmueble::class, 'inmueble_caracteristica_inmueble', 'id_inmueble', 'id_caracteristica_inmueble');
    }

    /**
     * The formatos that belong to the inmueble.
     */
    public function formatos()
    {
        return $this->belongsToMany(Formato::class, 'formato_inmueble', 'id_inmueble', 'id_formato');
    }

    /**
     * Get the inmueble that owns the inmueble.
     */
    public function idInmueblePadre()
    {
        return $this->belongsTo(InmueblePadre::class, 'id_tabla_hija');
    }

    /**
     * Get the administrador referente record associated with the inmueble.
     */
    public function idAdministradorReferente()
    {
        return $this->hasOne(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'ADMINISTRADOR')->where('referente', true);
    }

    /**
     * Get the inquilino referente record associated with the inmueble.
     */
    public function idInquilinoReferente()
    {
        return $this->hasOne(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'INQUILINO')->where('referente', true);
    }

    /**
     * Get the propietario referente record associated with the inmueble.
     */
    public function idPropietarioReferente()
    {
        return $this->hasOne(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'PROPIETARIO')->where('referente', true);
    }

    /**
     * Get the tipo inmueble that owns the inmueble.
     */
    public function idTipoInmueble()
    {
        return $this->belongsTo(TipoInmueble::class, 'id_tipo_inmueble');
    }

    public function idUnidad()
    {
        return $this->belongsTo(Unidad::class, 'id_tabla_hija');
    }

    /**
     * Get the usuario creador that owns the inmueble.
     */
    public function idUsuarioCreador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }

    /**
     * Get the inquilinos for the inmueble.
     */
    public function inquilinos()
    {
        return $this->hasMany(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'INQUILINO');
    }

    /**
     * Get the nominaciones for the inmueble.
     */
    public function nominaciones()
    {
        return $this->hasMany(Nominacion::class, 'id_inmueble');
    }

    /**
     * The personas that belong to the inmueble.
     */
    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'inmueble_persona', 'id_inmueble', 'id_persona')
            ->withPivot(['dia_cobro_mensual','enum_estado','enum_rol','fecha_fin_contrato','fecha_inicio_contrato','id_moneda_salario','id_persona', 'referente','salario']);
    }

    /**
     * Get the propietarios for the inmueble.
     */
    public function propietarios()
    {
        return $this->hasMany(InmueblePersona::class, 'id_inmueble')->where('enum_estado', 'ACTIVO')->where('enum_rol', 'PROPIETARIO');
    }

    /**
     * Get the rentas for the inmueble.
     */
    public function rentas()
    {
        return $this->hasMany(Renta::class, 'id_inmueble');
    }

    /**
     * Get the pagares for the inmueble.
     */
    public function pagares()
    {
        return $this->hasMany(Pagare::class, 'id_inmueble');
    }

    /**
     * Get the unidades for the inmueble.
     */
    public function unidades()
    {
        return $this->hasMany(Unidad::class, 'id_inmueble');
    }
}
