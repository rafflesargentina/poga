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

    public function findNominaciones($idInmueblePadre)
    {
        $items = $this->whereHas('idInmueble', function($query) use($idInmueblePadre) {
	    $query->where('inmuebles.enum_estado', 'ACTIVO');	
		
	    // Pueden ser Inmuebles o Unidades
            $query->where('id_tabla_hija', $idInmueblePadre)->orHas('unidades');
        })->get();

        return $this->map($items);
    }

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
        $items = $this->with('idUnidad')->whereHas('idInmueble', function($query) { $query->where('inmuebles.enum_estado', 'ACTIVO'); })->where('id_persona_nominada', $idPersona)
            ->where('role_id', $roleId)
	    ->get();

	return $this->mapDondeFuiNominado($items);
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
            return [
		'estado' => $item->enum_estado,
		'fecha_hora' => $item->fecha_hora,
		'id' => $item->id,
		'id_persona_nominada' => $item->id_persona_nominada,
		'id_usuario_alta' => $item->usu_alta,
		'nombre_y_apellidos_persona_nominada' => $item->idPersonaNominada->nombre_y_apellidos,
                'nominado' => $item->idPersonaNominada,
		'rol' => $item->idRolNominado->name,
		'unidad' => $item->idUnidad ? $item->idUnidad->numero : null,
            ];
        });
    }

    /**
     * Map items collection for Donde Fui Nominado.
     *
     * @param  Collection $items
     *
     * @return array
     */
    protected function mapDondeFuiNominado($items)
    {
        return $items->map(function($item) {
	    $unidad = $item->idUnidad;
	    if ($item->idUnidad) {
		$inmueble = $item->idInmueble;    
		$direccion = $unidad->direccion;
		$inmueblePadre = $unidad->idInmueblePadre;
	    } else {
		$inmueble = $item->idInmueble;
		$direccion = $inmueble->direccion;
		$inmueblePadre = $inmueble->idInmueblePadre;
	    }

	    return [
		'direccion' => $direccion,
		'divisible_en_unidades' => $inmueblePadre->divisible_en_unidades,
		'estado' => $item->enum_estado,
                'id' => $inmueblePadre->id,
                'id_usuario_creador' => $inmueble->id_usuario_creador,
		'id_nominacion' => $item->id,
		'nominado' => $item->idPersonaNominada,
                'inmueble_completo' => $inmueblePadre->modalidad_propiedad === 'UNICO_PROPIETARIO',
		'nombre' => $inmueblePadre->nombre,
		'nombre_y_apellidos_persona_nominada' => $item->idPersonaNominada->nombre_y_apellidos,
		'rol' => $item->idRolNominado->name,
		'tipo' => $inmueble->tipo,
		'unidad' => $item->idUnidad ? $item->idUnidad->numero : null,
            ];
        });
    }
}
