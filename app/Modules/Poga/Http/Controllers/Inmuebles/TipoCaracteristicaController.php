<?php

namespace Raffles\Modules\Poga\Http\Controllers\Inmuebles;

use Raffles\Modules\Poga\Repositories\TipoCaracteristicaRepository;

use RafflesArgentina\ResourceController\ApiResourceController;

class TipoCaracteristicaController extends ApiResourceController
{
    //protected $formRequest = TipoCaracteristicaRequest::class;

    //protected $pruneHasOne = true;

    protected $repository = TipoCaracteristicaRepository::class;

    protected $resourceName = 'tipos-caracteristicas';

    /**
     * Get items collection.
     *
     * @param string $orderBy The order key.
     * @param string $order   The order direction.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    //public function getItemsCollection($orderBy = 'tipo', $order = 'desc')
    //{
        //if ($this->useSoftDeletes) {
            //return $this->repository->withTrashed()->orderBy($orderBy, $order)->get();
        //}
//
        //$model = $this->repository->where('id', request()->tipo)->first();
//
        //return $model->tipos_caracteristicas->unique('id');
    //}
}
