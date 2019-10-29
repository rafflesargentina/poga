<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Models\Traits\NominacionTrait;

use Illuminate\Database\Eloquent\Model;

class Nominacion extends Model
{
    use NominacionTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'nombre_y_apellidos_persona_nominada',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo_validacion',
        'dia_cobro_mensual',
        'enum_estado',
        'fecha_fin_contrato',
        'fecha_hora',
        'fecha_inicio_contrato',
        'id_inmueble',
        'id_moneda_salario',
        'id_persona_nominada',
        'id_usuario_principal',
        'role_id',
        'referente',
        'salario',
        'usu_alta',
        'usu_mod',
        'usu_elim',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nominaciones';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['idPersonaNominada', 'idRolNominado'];

    /**
     * Get the inmueble that owns the nominacion.
     */
    public function idInmueble()
    {
        return $this->belongsTo(Inmueble::class, 'id_inmueble');
    }

    /**
     * Get the moneda that owns the nominacion.
     */
    public function idMoneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda_salario');
    }

    /**
     * Get the persona nominada that owns the nominacion.
     */
    public function idPersonaNominada()
    {
        return $this->belongsTo(Persona::class, 'id_persona_nominada');
    }

    /**
     * Get the rol nominado that owns the nominacion.
     */
    public function idRolNominado()
    {
        return $this->belongsTo(\Caffeinated\Shinobi\Models\Role::class, 'role_id');
    }

    /**
     * Get the unidad that owns the renta.
     */
    public function idUnidad()
    {
        return $this->belongsTo(Unidad::class, 'id_inmueble', 'id_inmueble');
    }

    /**
     * Get the usuario principal that owns the nominacion.
     */
    public function idUsuarioPrincipal()
    {
        return $this->belongsTo(User::class, 'id_usuario_principal');
    }
}
