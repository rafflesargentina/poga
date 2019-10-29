<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Pagare;

use Caffeinated\Repository\Repositories\EloquentRepository;

class PagareRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Pagare::class;

    /**
     * @var array
     */
    public $tag = ['Pagare'];

    public function findPagares($idInmueblePadre, $user)
    {
        // Si el usuario tiene rol administrador.
	if ($user->role_id == 1) {
            $items = $this->whereHas('idInmueble', function($query) use($idInmueblePadre) {
		// Pueden ser Inmuebles
		$query->where('enum_tabla_hija', 'INMUEBLES_PADRE');
		$query->where('id_tabla_hija', $idInmueblePadre);
	    })
            // O unidades
            ->orWhereHas('idUnidad', function($q) use($idInmueblePadre) { $q->where('id_inmueble_padre', $idInmueblePadre); })
	    ->whereIn('enum_estado', ['A_CONFIRMAR_POR_ADMIN','ANULADO','CONFIRMADO','PENDIENTE'])->get();
	} else {
		$items = $this->where('id_persona_deudora', $user->id_persona)
		->whereIn('enum_estado', ['A_CONFIRMAR_POR_ADMIN','ANULADO','CONFIRMADO','PENDIENTE'])
		->whereHas('idInmueble', function($query) use($idInmueblePadre) {
		    // Pueden ser Inmuebles
	            $query->where('inmuebles.enum_estado', 'ACTIVO');
                    $query->where('enum_tabla_hija', 'INMUEBLES_PADRE');
                    $query->where('id_tabla_hija', $idInmueblePadre);
                })
                // O unidades
		->orWhereHas('idUnidad', function($q) use($idInmueblePadre) { $q->where('id_inmueble_padre', $idInmueblePadre); })
		->where('id_persona_deudora', $user->id_persona)
		->whereIn('enum_estado', ['A_CONFIRMAR_POR_ADMIN','ANULADO','CONFIRMADO','PENDIENTE'])->get();
	}

	return $this->map($items);
    }

    public function fetch($id_inmueble_padre){

        $items = $this->whereHas('idInmueble', function($query) use ($id_inmueble_padre) { return $query->where('id_tabla_hija', $id_inmueble_padre)->where('enum_tabla_hija', 'INMUEBLES_PADRE'); })
            ->where('enum_estado', '!=', 'INACTIVO')
            ->get();

        return $items;
    }



    public function actualizarEstado($data){

        $pagare = Pagare::findOrFail($data['idPagare']);
        $pagare->update([
	    'enum_estado' => $data['estado'],
            'enum_origen_fondos' => array_key_exists('enum_origen_fondos', $data) ? $data['enum_origen_fondos'] : null,
        ]);
        return $pagare;
     
    }

    /**
     * Map items collection.
     *
     * @param Collection $items
     *
     * @return array
     */
    protected function map($items)
    {
        return $items->map(
            function ($item) {
                $clasificacion = '';
	        switch ($item->enum_clasificacion_pagare) {
	            case 'COMISION_RENTA_ADMIN':
		        $clasificacion = 'Comisión Renta Administrador';
		    break;
		    case 'COMISION_RENTA_PRIM_ADMIN':
		        $clasificacion = 'Comisión. primer mes Renta Administrador';
		    break;
		    case 'EXPENSA':
			$clasificacion = 'Expensa';
	            break;
		    case 'MULTA_RENTA':
		        $clasificacion = 'Multa Renta atrasada';
		    break;
		    case 'OTRO':
		        $clasificacion = 'Otro';
		    break;
		    case 'RENTA':
		        $clasificacion = 'Renta';
		    break;
		    case 'SALARIO_ADMINISTRADOR':
		        $clasificacion = 'Salario del Administrador';
		    break;
		    case 'SALARIO_CONSERJE':
			$clasificacion = 'Salario del Conserje';
		    default:
		        $clasificacion = '';
		}

                $estado = '';
		switch ($item->enum_estado) {
		    case 'ANULADO':
		        $estado = 'Anulado';
		    break;
		    case 'PAGADO':
		        $estado = 'Pagado';
		    break;
		    case 'PENDIENTE':
		        $estado = 'Pendiente';
		    break;
	            case 'A_CONFIRMAR_POR_ADMIN':
		        $estado = 'A confirmar';
		    default:
		        $estado = '';
		}

		return [
                    'clasificacion' => $clasificacion,
		    'concepto' => $item->description,
		    'estado' => $estado,
		    'fecha' => $item->fecha_pagare,
		    'id' => $item->id,
		    'id_inmueble' => $item->id_inmueble,
		    'id_persona_acreedora' => $item->id_persona_acreedora,
		    'id_persona_deudora' => $item->id_persona_deudora,
		    'idInmueble' => $item->idInmueble,
		    'idPersonaAcreedora' => $item->idPersonaAcreedora,
		    'idPersonaDeudora' => $item->idPersonaDeudora,
		    'nombre_y_apellidos_persona_acreedora' => $item->idPersonaAcreedora ? $item->idPersonaAcreedora->nombre_y_apellidos : null,
		    'nombre_y_apellidos_persona_deudora' => $item->idPersonaDeudora ? $item->idPersonaDeudora->nombre_y_apellidos : null,
		    'moneda' => $item->idMoneda ? $item->idMoneda->moneda : null,
		    'monto' => $item->monto,
		    'unidad' => $item->idUnidad ? $item->idUnidad->numero : null,
		];
            }
        );
    } 
}
