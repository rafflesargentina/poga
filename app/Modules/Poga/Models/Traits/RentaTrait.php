<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait RentaTrait {
    /**
     * Get the moneda.
     *
     * @return string
     */
    public function getMonedaAttribute()
    {
        $moneda = $this->idMoneda;

        if (!$moneda) {
            return null;
        }

        return $moneda->moneda;
    }

    /**
     * Get the nombre y apellidos for the inquilino referente.
     *
     * @return string
     */
    public function getNombreYApellidosInquilinoReferenteAttribute()
    {
        $inquilino = $this->idInquilino;

        if (!$inquilino) {
            return null;
        }

        return $inquilino->nombre.' '.$inquilino->apellidos;
    }

    /**
     * Get the inquilino referente's id.
     *
     * @return string
     */
    public function getPersonaIdInquilinoReferenteAttribute()
    {
        return $this->id_inquilino;
    }
}
