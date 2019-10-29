<?php

namespace Raffles\Modules\Poga\Models;

use Raffles\Modules\Poga\Filters\PersonaFilters;
use Raffles\Modules\Poga\Sorters\PersonaSorters;
use Raffles\Modules\Poga\Models\Traits\PersonaTrait;

use Illuminate\Database\Eloquent\Model;
use RafflesArgentina\FilterableSortable\FilterableSortableTrait;

class Persona extends Model
{
    use FilterableSortableTrait, PersonaTrait;

    /**
     * The associated query filters.
     *
     * @var PersonaFilters
     */
    protected $filters = PersonaFilters::class;

    /**
     * The associated query sorters.
     *
     * @var PersonaSorters
     */
    protected $sorters = PersonaSorters::class;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'nombre_y_apellidos',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apellido',
        'ci',
        'cuenta_bancaria',
        'direccion',
        'mail',
        'enum_estado',
        'enum_tipo_persona',
        'enum_sexo',
        'fecha_nacimiento',
        'id',
        'id_pais',
        'id_pais_cobertura',
        'id_usuario_creador',
        'mail_solicitudes',
        'nombre',
        'ruc',
        'telefono',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas';

    /**
     * Get the ciudades cobertura for the persona.
     */
    public function ciudades_cobertura()
    {
        return $this->hasMany(CiudadCobertura::class, 'id_persona');
    }

    /**
     * Get the usuario that owns the persona.
     */
    public function idUsuarioCreador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }

    /**
     * The inmuebles that belong to the persona.
     */
    public function inmuebles()
    {
        return $this->belongsToMany(Inmueble::class, 'inmueble_persona', 'id_persona', 'id_inmueble')
            ->withPivot(['dia_cobro_mensual','enum_estado','enum_rol','fecha_fin_contrato','fecha_inicio_contrato','id_moneda_salario','referente','salario']);
    }

    /**
     * Get the nominaciones for the persona.
     */
    public function nominaciones()
    {
        return $this->hasMany(Nominacion::class, 'id_persona_nominada');
    }

    /**
     * Get the rentas for the persona.
     */
    public function rentas()
    {
        return $this->hasMany(Renta::class, 'id_inquilino');
    }

    /**
     * The servicios that belong to the persona.
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'proveedor_servicio', 'id_proveedor', 'id_servicio');
    }

    /**
     * Get the user record associated with the persona.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id_persona');
    }
}
