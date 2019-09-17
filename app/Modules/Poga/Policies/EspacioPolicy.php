<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Espacio;
use Illuminate\Auth\Access\HandlesAuthorization;

class EspacioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the espacio.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function view(User $user, Espacio $espacio)
    {
        return true;
    }

    /**
     * Determine whether the user can create espacios.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function create(User $user, Espacio $espacio)
    {
        switch ($user->role_id) {
	    // Administrador
	    case 1:
                // Puede crear un espacio si la persona es administrador del condominio.
                $inmueble = $espacio->idInmueble;
		return $inmueble->administradores->where('id', $user->id_persona)
		    && $inmueble->idInmueblePadre->modalidad_propiedad === 'EN_CONDOMINIO'
		    && $inmueble->enum_tabla_hija === 'INMUEBLE_PADRE';
	    break;

	    // Conserje
	    case 2:
               return false;
            break;

	    // Inquilino
	    case 3:
                return false;
            break;	

	    // Propietario
	    case 4:
	        return false;	    
            break;	

	    // Proveedor
	    case 5:
                return false;
	
	    default:
	        return false;
	}

	return false;
    }

    /**
     * Determine whether the user can update the espacio.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function update(User $user, Espacio $espacio)
    {
        $this->create($user, $espacio);
    }

    /**
     * Determine whether the user can delete the espacio.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function delete(User $user, Espacio $espacio)
    {
        $this->create($user, $espacio);
    }

    /**
     * Determine whether the user can restore the espacio.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function restore(User $user, Espacio $espacio)
    {
        $this->create($user, $espacio);    
    }

    /**
     * Determine whether the user can permanently delete the espacio.
     *
     * @param  User     $user
     * @param  Espacio  $espacio
     *
     * @return mixed
     */
    public function forceDelete(User $user, Espacio $espacio)
    {
        $this->create($user, $espacio);    
    }
}
