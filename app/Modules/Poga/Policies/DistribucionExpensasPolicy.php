<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DistribucionExpensasPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
        $this->create($user);   
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $inmueble = $espacio->idInmueble;
        
        switch ($user->role_id) {
	    // Administrador
            case 1:
                
                return $inmueble->administradores->where('id', $user->id_persona);

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
    public function update(User $user)
    {
        //
        $this->create($user); 
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $this->create($user); 
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        //
        $this->create($user); 
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
        $this->create($user); 
    }
}
