<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait NominacionTrait
{
    public function getNombreYApellidosPersonaNominadaAttribute()
    {
        $persona = $this->idPersonaNominada;

        if (!$persona) {
            return null;
        }

        return $persona->nombre_y_apellidos;
    }
}
