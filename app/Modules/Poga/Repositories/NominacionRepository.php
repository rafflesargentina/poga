<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Nominacion;

use Caffeinated\Repository\Repositories\EloquentRepository;

class NominacionRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Nominacion::class;

    /**
     * @var array
     */
    public $tag = ['Nominacion'];

    /**
     * Find: Donde Fui Nominado.
     *
     * @param  int $idPersona The Persona model id.
     * @param  int $roleId    The Role model id.
     *
     * @return array
     */
    public function dondeFuiNominado($idPersona, $roleId)
    {
        $items = $this->where('id_persona_nominada', $idPersona)
            ->where('role_id', $roleId)
	    ->get();

	return $this->map($items);
    }

    /**
     * Map items collection.
     *
     * @param  Collection $items
     *
     * @return array
     */
    protected function map($items)
    {
        return $items->map(function($item) {
	    $inmueble = $item->idInmueble;

	    return [
                'cant_unidades' => $inmueble->unidades->count(),
                'direccion' => $inmueble->direccion,
                'divisible_en_unidades' => $item->divisible_en_unidades,
                'id' => $inmueble->id_inmueble_padre ?: $inmueble->id_tabla_hija,
                'id_usuario_creador' => $inmueble->id_usuario_creador,
                'id_nominacion' => $item->id,
                'enum_estado_nominacion' => $item->enum_estado,
                'inmueble_completo' => $inmueble->idInmueblePadre->modalidad_propiedad === 'UNICO_PROPIETARIO',
                'nombre' => $inmueble->idInmueblePadre->nombre,
                'nombre_y_apellidos_administrador_referente' => $inmueble->nombre_y_apellidos_administrador_referente,
                'nombre_y_apellidos_inquilino_referente' => $inmueble->nombre_y_apellidos_inquilino_referente,
                'nombre_y_apellidos_propietario_referente' => $inmueble->nombre_y_apellidos_propietario_referente,
                'persona_id_administrador_referente' => $inmueble->persona_id_administrador_referente,
                'persona_id_inquilino_referente' => $inmueble->persona_id_inquilino_referente,
                'tipo' => $inmueble->tipo,
            ];
        });
    }
}
