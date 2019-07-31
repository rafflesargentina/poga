<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait SolicitudTrait
{
    public function getNombreServicioAttribute()
    {
        $servicio = $this->idServicio;

        if (!$servicio) {
            return null;
        }

        return $servicio->nombre;
    }


    public function getNombreYApellidosUsuarioCreadorAttribute()
    {
        $usuarioCreador = $this->idUsuarioCreador;

        if (!$usuarioCreador) {
            return null;
        }

        $persona = $usuarioCreador->idPersona;

        if (!$persona) {
            return null;
        }

        return $persona->nombre_y_apellidos;
    }
}
