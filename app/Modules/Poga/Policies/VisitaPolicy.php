<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Visita;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Visita  $visita
     * @return mixed
     */
    public function view(User $user, Visita $visita)
    {
        //
        switch ($user->role_id) {
            // Administrador
            case 1:                    
                
                return true;
                

            break;
    
            // Conserje
            case 2:
                return true;
            break;
    
            // Inquilino
            case 3:
                return true;
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
     * Determine whether the user can create visitas.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Evento $evento)
    {
        //
        switch ($user->role_id) {
            // Administrador
            case 1:                    
                
                $inmueble = $evento->idInmueble;   
                return  $evento->enum_tipo_evento == "VISITA" 
                && $inmueble->administradores->where('id', $user->id_persona)
                && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                

            break;
    
            // Conserje
            case 2:
                   return false;
                break;
    
            // Inquilino
            case 3:
                $inmueble = $evento->idInmueble;   
                return  $evento->enum_tipo_evento == "VISITA" 
                && $inmueble->inquilinos->where('id', $user->id_persona)
                && $inmueble->enum_tabla_hija == "UNIDAD"; 
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
     * Determine whether the user can update the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Visita  $visita
     * @return mixed
     */
    public function update(User $user, Visita $visita)
    {
        //
        $this->create($user, $visita); 
    }

    /**
     * Determine whether the user can delete the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Visita  $visita
     * @return mixed
     */
    public function delete(User $user, Visita $visita)
    {
        $this->create($user, $visita); 
    }

    /**
     * Determine whether the user can restore the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Visita  $visita
     * @return mixed
     */
    public function restore(User $user, Visita $visita)
    {
        //
        $this->create($user, $visita); 
    }

    /**
     * Determine whether the user can permanently delete the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Visita  $visita
     * @return mixed
     */
    public function forceDelete(User $user, Visita $visita)
    {
        //
        $this->create($user, $visita); 
    }
}
