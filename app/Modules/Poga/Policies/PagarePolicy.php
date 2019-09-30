<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Pagare;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagarePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the pagare.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     * 
     * @return mixed
     */
    public function view(User $user, Pagare $pagare)
    {       
        return $this->update($user, $pagare);    
    }

    /**
     * Determine whether the user can create pagares.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     * 
     * @return mixed
     */
    public function create(User $user, Pagare $pagare)
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
    }

    /**
     * Determine whether the user can update the pagare.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     *
     * @return mixed
     */
    public function update(User $user, Pagare $pagare)
    {
        //
        $inmueble = $pagare->idInmueble;      

        

        switch ($user->role_id) {
            // Administrador
            case 1:                 
           
                return $inmueble->administradores->where('id', $user->id_persona);
                   
            
            break;
    
            // Conserje
            case 2:         
                return false;
    
            // Inquilino
            case 3:     

               
                        return $inmueble->inquilinos->where('id', $user->id_persona)
                        && $pagare->idPersonaAdeudora() == $user->id_persona; 
                        break;	
                   
            
            // Propietario
            case 4:
                
               
                        return $inmueble->propietarios->where('id', $user->id_persona)
                        && $pagare->idPersonaAdeudora() == $user->id_persona; 
                        break;	
                   

                
    
            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the pagare.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     *
     * @return mixed
     */
    public function delete(User $user, Pagare $pagare)
    {
        return $this->update($user, $pagare); 
    }

    /**
     * Determine whether the user can restore the pagare.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     *
     * @return mixed
     */
    public function restore(User $user, Pagare $pagare)
    {
        return $this->update($user, $pagare); 
    }

    /**
     * Determine whether the user can permanently delete the pagare.
     *
     * @param  User   $user
     * @param  Pagare $pagare
     *
     * @return mixed
     */
    public function forceDelete(User $user, Pagare $pagare)
    {
        return $this->update($user, $pagare); 
    }
}