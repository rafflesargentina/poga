<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait DireccionTrait {
    /**
     * Get the direccion.
     *
     * @return string
     */
    public function getDireccionAttribute()
    {
        return $this->calle_principal.' '.$this->calle_secundaria.' '.$this->numeracion;
    }
}
