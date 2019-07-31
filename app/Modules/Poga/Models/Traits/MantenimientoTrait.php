<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait MantenimientoTrait
{
    public function getCostoAttribute()
    {
        $moneda = $this->idMoneda;

        if (!$moneda) {
            return null;
        }

        return $moneda->abbr.' '.$this->monto;
    }

    public function getFrecuenciaAttribute()
    {
        return $this->enum_se_repite ?? 'Única vez';
    }
}
