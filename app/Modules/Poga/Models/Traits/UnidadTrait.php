<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait UnidadTrait {
    /**
     * Get the tipo.
     *
     * @return string
     */
    public function getTipoAttribute()
    {
        $tipoInmueble = $this->idInmueble->idTipoInmueble;

        if (!$tipoInmueble) {
            return null;
        }

        $nombre = $tipoInmueble->tipo;

        return $nombre;
    }

    /**
     * Get the administrador referente's id.
     *
     * @return string
     */
    public function getPersonaIdAdministradorReferenteAttribute()
    {
        return $this->idInmueble->persona_id_administrador_referente;
    }

    /**
     * Get the inquilino referente's id.
     *
     * @return string
     */
    public function getPersonaIdInquilinoReferenteAttribute()
    {
        return $this->idInmueble->persona_id_inquilino_referente;
    }

    /**
     * Get the propietario referente's id.
     *
     * @return string
     */
    public function getPersonaIdPropietarioReferenteAttribute()
    {
        return $this->idInmueble->persona_id_propietario_referente;
    }

    /**
     * Get the administrador referente's nombre y apellidos.
     *
     * @return int
     */
    public function getNombreYApellidosAdministradorReferenteAttribute()
    {
        return $this->idInmueble->nombre_y_apellidos_administrador_referente;
    }

    /**
     * Get the inquilino referente's nombre y apellidos.
     *
     * @return int
     */
    public function getNombreYApellidosInquilinoReferenteAttribute()
    {
        return $this->idInmueble->nombre_y_apellidos_inquilino_referente;
    }

    /**
     * Get the propietario referente's nombre y apellidos.
     *
     * @return int
     */
    public function getNombreYApellidosPropietarioReferenteAttribute()
    {
        return $this->idInmueble->nombre_y_apellidos_propietario_referente;
    }
}
