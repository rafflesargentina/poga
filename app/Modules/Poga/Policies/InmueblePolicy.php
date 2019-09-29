<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Inmueble;
use Illuminate\Auth\Access\HandlesAuthorization;

class InmueblePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function view(User $user, Inmueble $inmueble)
    {
        return true;
        
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Inmueble $inmueble)
    {
       
        
        switch ($user->role_id) {
            // Administrador
            case 1:
           
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
     * Determine whether the user can update the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function update(User $user, Inmueble $inmueble)
    {
        
        
        switch ($user->role_id) {
            // Administrador
            case 1:   
                return $inmueble->administradores->where('id', $user->id_persona);       
            
            break;
    
            // Conserje
            case 2:
                return $inmueble->conserjes->where('id', $user->id_persona);
    
            // Inquilino
            case 3:
                return $inmueble->inquilinos->where('id', $user->id_persona);
           
            
            // Propietario
            case 4:
                
                return $inmueble->propietarios->where('id', $user->id_persona);
                break;	
    
            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function delete(User $user, Inmueble $inmueble)
    {
        //
        return $this->create($user, $inmueble); 
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function restore(User $user, Inmueble $inmueble)
    {
        //
        return $this->create($user, $inmueble); 
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function forceDelete(User $user, Inmueble $inmueble)
    {
        //
        return $this->create($user, $inmueble); 
    }
}
