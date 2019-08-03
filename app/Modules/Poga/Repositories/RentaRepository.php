<?php

namespace Raffles\Modules\Poga\Repositories;

use Raffles\Modules\Poga\Models\Renta;

use Caffeinated\Repository\Repositories\EloquentRepository;

class RentaRepository extends EloquentRepository
{
    /**
     * @var Model
     */
    public $model = Renta::class;

    /**
     * @var array
     */
    public $tag = ['Renta'];

    public function fetchRentas($id_inmueble_padre){

        $items = $this->whereHas('idInmueble', function($query) use ($id_inmueble_padre) { return $query->where('inmuebles.id_tabla_hija', $id_inmueble_padre)->where('enum_tabla_hija','INMUEBLES_PADRE'); })->get();

        return $items;
    }

    public function create($data){       

        $renta = new Renta($data);
        $renta->save();

        return $renta;

    }

    public function updateRenta($request,$id){
       
        $model = $this->find($id);
        $model->update($request);

    }

   
}
