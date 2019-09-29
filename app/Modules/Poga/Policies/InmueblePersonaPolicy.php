<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\InmueblePersona;
use Illuminate\Auth\Access\HandlesAuthorization;

class InmueblePersonaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\InmueblePersona  $inmueblePersona
     * @return mixed
     */
    public function view(User $user, InmueblePersona $inmueblePersona)
    {
        return true;
        
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, InmueblePersona $inmueblePersona)
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
     * @param  \Raffles\Modules\Poga\Models\InmueblePersona  $inmueblePersona
     * @return mixed
     */
    public function update(User $user, InmueblePersona $inmueblePersona)
    {
        //
      
        return $this->create($user, $inmueblePersona); 
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\InmueblePersona  $inmueblePersona
     * @return mixed
     */
    public function delete(User $user, InmueblePersona $inmueblePersona)
    {
        //
        return $this->create($user, $inmueblePersona); 
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\InmueblePersona  $inmueblePersona
     * @return mixed
     */
    public function restore(User $user, InmueblePersona $inmueblePersona)
    {
        //
        return $this->create($user, $inmueblePersona); 
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\InmueblePersona  $inmueblePersona
     * @return mixed
     */
    public function forceDelete(User $user, InmueblePersona $inmueblePersona)
    {
        //
        return $this->create($user, $inmueblePersona); 
    }
}
