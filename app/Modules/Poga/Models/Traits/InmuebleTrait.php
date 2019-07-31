<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait InmuebleTrait {
    /**
     * Get the inmueble padre unidades count.
     *
     * @return int
     */
    public function getCantUnidadesAttribute()
    {
        return $this->unidades->count();
    }

    /**
     * Get the direccion.
     *
     * @return string
     */
    public function getDireccionAttribute()
    {
        $inmueblePadre = $this->idInmueblePadre;

        if (!$inmueblePadre) {
            return null;
        }

        $direccion = $inmueblePadre->idDireccion;

        if (!$direccion) {
            return null;
        }

        return $direccion->calle_principal.' c/'.$direccion->calle_secundaria.' '.$direccion->numeracion;
    }

    /**
     * Get the administrador referente's id.
     *
     * @return string
     */
    public function getPersonaIdAdministradorReferenteAttribute()
    {
        $administrador = $this->idAdministradorReferente;

        if (!$administrador) {
            return null;
        }

        $persona = $administrador->idPersona;

        if (!$persona) {
            return null;
        }

        return $persona->id;
    }

    /**
     * Get the inquilino referente's id.
     *
     * @return string
     */
    public function getPersonaIdInquilinoReferenteAttribute()
    {
        $inquilino = $this->idInquilinoReferente;

        if (!$inquilino) {
            return null;
        }

        $persona = $inquilino->idPersona;

        if (!$persona) {
            return null;
        }

        return $persona->id;
    }

    /**
     * Get the propietario referente's id.
     *
     * @return string
     */
    public function getPersonaIdPropietarioReferenteAttribute()
    {
        $propietario = $this->idPropietarioReferente;

        if (!$propietario) {
            return null;
        }

        $persona = $propietario->idPersona;

        if (!$persona) {
            return null;
        }

        return $persona->id;
    }

    /**
     * Get the administrador referente's nombre y apellidos.
     *
     * @return string
     */
    public function getNombreYApellidosAdministradorReferenteAttribute()
    {
        $administrador = $this->idAdministradorReferente;

        if (!$administrador) {
            return null;
        }

        $persona = $administrador->idPersona;

        return $persona->nombre.' '.$persona->apellido;
    }

    /**
     * Get the inquilino referente's nombre y apellidos.
     *
     * @return string
     */
    public function getNombreYApellidosInquilinoReferenteAttribute()
    {
        $inquilino = $this->idInquilinoReferente;

        if (!$inquilino) {
            return null;
        }

        $persona = $inquilino->idPersona;

        return $persona->nombre.' '.$persona->apellido;
    }

    /**
     * Get the propietario referente's nombre y apellidos.
     *
     * @return string
     */
    public function getNombreYApellidosPropietarioReferenteAttribute()
    {
        $propietario = $this->idPropietarioReferente;

        if (!$propietario) {
            return null;
        }

        $persona = $propietario->idPersona;

        return $persona->nombre.' '.$persona->apellido;
    }

    /**
     * Get the tipo.
     *
     * @return string
     */
    public function getTipoAttribute()
    {
        $tipo = $this->idTipoInmueble;

        if (!$tipo) {
            return null;
        }

        return $tipo->tipo;
    }
}
