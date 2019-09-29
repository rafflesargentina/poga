<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\{User,Persona};
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function view(User $user, Persona $persona)
    {
        //
        return $this->create($user,$persona);   
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function create(User $user,Persona $persona)
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
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function update(User $user,Persona $persona)
    {
        //
        return $this->create($user,$persona); 
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function delete(User $user,Persona $persona)
    {
        //
        return $this->create($user,$persona); 
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function restore(User $user,Persona $persona)
    {
        //
        return $this->create($user,$persona); 
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Persona  $persona
     * @return mixed
     */
    public function forceDelete(User $user,Persona $persona)
    {
        //
        return $this->create($user,$persona); 
    }
}
