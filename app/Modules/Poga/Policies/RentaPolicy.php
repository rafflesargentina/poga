<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Renta;
use Illuminate\Auth\Access\HandlesAuthorization;

class RentaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Renta.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Renta  $Renta
     * @return mixed
     */
    public function view(User $user, Renta $renta)
    {
        switch ($user->role_id) {
            // Administrador
            case 1:      
                $inmueble = $renta->idInmueble;                
                return $inmueble->administradores->where('id', $user->id_persona);
            break;
    
            // Conserje
            case 2:
                return false;
            break;
    
            // Inquilino
            case 3:
                return true;
            break;	
    
            // Propietario
            case 4:
                return true;
            break;
            // Proveedor
            case 5:
                return false;
            break;
            default:
                return false;
        }  
    }

    /**
     * Determine whether the user can create Rentas.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Renta $renta)
    {
        //
        switch ($user->role_id) {
            // Administrador
            case 1:      
            
                $inmueble = $renta->idInmueble;                
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
    }

    /**
     * Determine whether the user can update the Renta.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $renta
     * @return mixed
     */
    public function update(User $user, Renta $renta)
    {
        //
        $this->create($user, $renta);   
    }

    /**
     * Determine whether the user can delete the Renta.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $renta
     * @return mixed
     */
    public function delete(User $user, Renta $renta)
    {
        //
        $this->create($user, $renta); 
    }

    /**
     * Determine whether the user can restore the Renta.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $renta
     * @return mixed
     */
    public function restore(User $user, Renta $renta)
    {
        //
        $this->create($user, $renta); 
    }

    /**
     * Determine whether the user can permanently delete the Renta.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $renta
     * @return mixed
     */
    public function forceDelete(User $user, Renta $renta)
    {
        //
        $this->create($user, $renta); 
    }
}
