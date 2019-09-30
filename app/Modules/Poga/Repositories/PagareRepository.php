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

    public function findPagares($idInmueblePadre)
    {
        $items = $this->whereHas('idInmueble', function($query) use($idInmueblePadre) {
            // Pueden ser Inmuebles o Unidades
            $query->where('id_tabla_hija', $idInmueblePadre)->orHas('unidades');
	})->whereIn('enum_estado', ['A_CONFIRMAR','ANULADO','CONFIRMADO','PENDIENTE'])->get();

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
		 return [
                     'clasificacion' => $item->enum_clasificacion_pagare,
		     'concepto' => $item->description,
		     'estado' => $item->enum_estado,
		     'fecha' => $item->fecha_pagare,
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
