<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Mantenimiento;

use Illuminate\Auth\Access\HandlesAuthorization;

class MantenimientoPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the mantenimiento.
     *
     * @param  User           $user
     * @param  Mantenimiento  $mantenimiento
     *
     * @return mixed
     */
    public function view(User $user, Mantenimiento $mantenimiento)
    {
        return $this->update($user, $mantenimiento);   
    }

    /**
     * Determine whether the user can create mantenimientos.
     *
     * @param  User          $user
     * @param  Mantenimiento $mantenimiento
     *
     * @return mixed
     */
    public function create(User $user, Mantenimiento $mantenimiento)
    {
      die("asdaDS");
        switch ($user->role_id) {
            // Administrador
            case 1:   
                return true;      
            break;
    
            // Conserje
            case 2:
                return true;
    
            // Inquilino
            case 3:
                return true;
            
            // Propietario
            case 4:
                return true;	
    
            // Proveedor
            case 5:
                return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can update the mantenimiento.
     *
     * @param  User           $user
     * @param  Mantenimiento  $mantenimiento
     *
     * @return mixed
     */
    public function update(User $user, Mantenimiento $mantenimiento)
    {
	$inmueble = $mantenimiento->idInmueble;     

        switch ($user->role_id) {
            // Administrador
            case 1:   
                return $inmueble->idAdministradorReferente->id_persona === $user->id_persona;
            
            break;
    
            // Conserje
            case 2:
                return $inmueble->conserjes->where('id', $user->id_persona);
    
            // Inquilino
            case 3:
                return $inmueble->idInquilinoReferente->id_persona === $user->id_persona
                && $inmueble->solicitud_directa_inquilinos;
                break;	
            
            // Propietario
            case 4:
                
                return $inmueble->idPropietarioReferente->id_persona === $user->id_persona;
                break;	
    
            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the mantenimiento.
     *
     * @param  User           $user
     * @param  Mantenimiento  $mantenimiento
     *
     * @return mixed
     */
    public function delete(User $user, Mantenimiento $mantenimiento)
    {
        return $this->update($user, $mantenimiento); 
    }

    /**
     * Determine whether the user can restore the mantenimiento.
     *
     * @param  User           $user
     * @param  Mantenimiento  $mantenimiento
     *
     * @return mixed
     */
    public function restore(User $user, Mantenimiento $mantenimiento)
    {
        return $this->update($user, $mantenimiento); 
    }

    /**
     * Determine whether the user can permanently delete the mantenimiento.
     *
     * @param  User           $user
     * @param  Mantenimiento  $mantenimiento
     *
     * @return mixed
     */
    public function forceDelete(User $user, Mantenimiento $mantenimiento)
    {
        return $this->update($user, $mantenimiento); 
    }
}
