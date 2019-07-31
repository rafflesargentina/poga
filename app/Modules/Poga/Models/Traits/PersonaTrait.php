<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait PersonaTrait
{
    public function getNombreYApellidosAttribute()
    {
        return $this->nombre.' '.$this->apellido;
    }
}
