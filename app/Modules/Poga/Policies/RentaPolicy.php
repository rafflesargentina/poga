<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Illuminate\Auth\Access\HandlesAuthorization;

class RentaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the renta.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function view(User $user, Renta $renta)
    {
        return true;
    }

    /**
     * Determine whether the user can create rentas.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function create(User $user, Renta $renta)
    {
        switch ($user->role_id) {
            // Administrador
            case 1:
		// No se pueden realizar operaaciones sin propietario referente del inmueble o la unidad.    
		//if (!$renta->idInmueble->idPropietarioReferente) {
                    //return false;
		//}	

		return true;
		
	    // Conserje
            case 2:
                return false;
	    
	    // Inquilino
            case 3:
                return false;
	    
	    // Propietario
            case 4:
	        return false;
	    
	    // Proveedor
            case 5:
                return false;
	    
	    default:
                return false;
        }

        return false;
    }

    /**
     * Determine whether the user can update the renta.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function update(User $user, Renta $renta)
    {
        switch ($user->role_id) {
            // Administrador
            case 1:   
                // No se pueden realizar operaaciones sin propietario referente del inmueble o la unidad.
                if (!$renta->idInmueble->idPropietarioReferente) {
                    return false;
		}    

		return $renta->idInmueble->administradores->where('id', $user->id_persona);       
            
            break;
    
            // Conserje
            case 2:
                return false;
    
            // Inquilino
            case 3:
                return false;
           
            // Propietario
            case 4:
                return false;

            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the renta.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function delete(User $user, Renta $renta)
    {
        return $this->create($user, $renta); 
    }

    /**
     * Determine whether the user can restore the renta.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function restore(User $user, Renta $renta)
    {
        return $this->create($user, $renta); 
    }

    /**
     * Determine whether the user can permanently delete the renta.
     *
     * @param  User  $user
     * @param  Renta $renta
     *
     * @return mixed
     */
    public function forceDelete(User $user, Renta $renta)
    {
        return $this->create($user, $renta); 
    }
}
