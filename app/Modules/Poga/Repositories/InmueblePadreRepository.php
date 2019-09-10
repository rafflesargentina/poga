<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\{ InmueblePadre, User };

use Caffeinated\Repository\Repositories\EloquentRepository;

class InmueblePadreRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = InmueblePadre::class;

    /**
     * @var array
     */
    public $tag = ['InmueblePadre'];

    /**
     *
     */
    public function findDisponiblesAdministrar()
    {
        $items = $this->whereHas('idInmueble', function($query) { return $query->doesntHave('idAdministradorReferente')->where('enum_estado', 'ACTIVO'); })
            ->orWhereHas('unidades', function($query) { return $query->doesntHave('idInmueble.idAdministradorReferente'); })
            ->get();

        $map = $items->map(
            function ($item) {
                $inmueble = $item->idInmueble;

                return [
                    'cant_unidades' => $item->unidades->count(),
                    'direccion' => $inmueble->direccion,
                    'divisible_en_unidades' => $item->divisible_en_unidades,
                    'id' => $item->id,
                    'id_usuario_creador' => $inmueble->id_usuario_creador,
                    'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                    'nombre' => $item->nombre,
                    'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                    'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                    'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                    'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                    'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                    'tipo' => $inmueble->tipo,
                ];
            }
        );

        return $map;
    }

    /**
     * User $user The User model.
     */
    public function findMisInmuebles(User $user)
    {
        $user->idPersona->inmuebles->loadMissing('unidades');

        //$items = $user->idPersona->inmuebles->where('enum_estado', 'ACTIVO')->where('enum_tabla_hija', 'INMUEBLES_PADRE');
        $items = $this->whereHas('idInmueble', function($query) use($user) { return $query->where('inmuebles.enum_estado', 'ACTIVO')->whereHas('personas', function($q) use($user) { return $q->where('personas.id', $user->id_persona)->where('personas.enum_estado', 'ACTIVO'); }); })->get();

        $map = $items->map(
            function ($item) {
                return [
                    'cant_unidades' => $item->unidades->count(),
                    'direccion' => $item->idInmueble->direccion,
                    'divisible_en_unidades' => $item->divisible_en_unidades,
                    'id' => $item->id,
                    'id_usuario_creador' => $item->id_usuario_creador,
                    'inmueble_completo' => $item->idAdministradorReferente ? false : true,
                    'nombre' => $item->nombre,
                    'nombre_y_apellidos_administrador_referente' => $item->nombre_y_apellidos_administrador_referente,
                    'nombre_y_apellidos_inquilino_referente' => $item->nombre_y_apellidos_inquilino_referente,
                    'nombre_y_apellidos_propietario_referente' => $item->nombre_y_apellidos_propietario_referente,
                    'persona_id_administrador_referente' => $item->persona_id_administrador_referente,
                    'persona_id_inquilino_referente' => $item->persona_id_inquilino_referente,
                    'persona_id_propietario_referente' => $item->persona_id_propietario_referente,
                    'tipo' => $item->idInmueble->tipo,
                ];
            }
        );

        return $map;
    }

    /**
     *
     */
    public function findTodos()
    {
        $items = $this->with('unidades')->get();

        $map = $items->map(
            function ($item) {
                $inmueble = $item->idInmueble;

                return [
                    'cant_unidades' => $item->unidades->count(),
                    'direccion' => $inmueble->direccion,
                    'divisible_en_unidades' => $item->divisible_en_unidades,
                    'id' => $item->id,
                    'id_usuario_creador' => $inmueble->id_usuario_creador,
                    'inmueble_completo' => $inmueble->idAdministradorReferente ? false : true,
                    'nombre' => $item->nombre,
                    'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                    'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                    'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                    'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                    'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                    'tipo' => $inmueble->tipo,
                ];
            }
        );
    }
}
