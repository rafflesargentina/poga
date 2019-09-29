<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\{User,DistribucionExpensa};
use Illuminate\Auth\Access\HandlesAuthorization;

class DistribucionExpensaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function view(User $user, DistribucionExpensa $distribucionExpensa)
    {
        //
        return $this->create($user,$distribucionExpensa);   
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user,DistribucionExpensa $distribucionExpensa)
    {       
        switch ($user->role_id) {
	    // Administrador
            case 1:                
                return true;
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
     * Determine whether the user can update the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function update(User $user,DistribucionExpensa $distribucionExpensa)
    {
        //
        return $this->create($user,$distribucionExpensa,); 
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function delete(User $user,DistribucionExpensa $distribucionExpensa)
    {
        //
        return $this->create($user,$distribucionExpensa); 
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function restore(User $user,DistribucionExpensa $distribucionExpensa)
    {
        //
        return $this->create($user,$distribucionExpensa); 
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user,DistribucionExpensa $distribucionExpensa)
    {
        //
        return $this->create($user,$distribucionExpensa); 
    }
}
