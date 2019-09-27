<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Solicitud;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitudPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the solicitud.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Solicitud  $solicitud
     * @return mixed
     */
    public function view(User $user, Solicitud $solicitud)
    {
        //
        //
        switch ($user->role_id) {
            // Administrador
            case 1:      
                $inmueble = $solicitud->idInmueble;     
                return  $inmueble->administradores->where('id', $user->id_persona);

            break;
    
            // Conserje
            case 2:
                return true;
            break;
    
            // Inquilino
            case 3:
                return  $inmueble->inquilinos->where('id', $user->id_persona);
                break;	
    
            // Propietario
            case 4:
                return  $inmueble->propietarios->where('id', $user->id_persona);               
                break;	
    
            // Proveedor
            case 5:
                return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can create solicituds.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Solicitud $solicitud)
    {
        //
       
        
        switch ($user->role_id) {
            // Administrador
            case 1:      
                $inmueble = $solicitud->idInmueble;   
                
                return  $inmueble->administradores->where('id', $user->id_persona)
                &&  $inmueble->enum_tabla_hija === 'INMUEBLE_PADRE';

            break;
    
            // Conserje
            case 2:
                   return false;
                break;
    
            // Inquilino
            case 3:
                 
                return  $inmueble->inquilinos->where('id', $user->id_persona)
                &&  $inmueble->enum_tabla_hija === 'UNIDADES';

            break;	
    
            // Propietario
            case 4:
                return  $inmueble->propietarios->where('id', $user->id_persona); 
            break;	
    
            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can update the solicitud.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Solicitud  $solicitud
     * @return mixed
     */
    public function update(User $user, Solicitud $solicitud)
    {
        //
        $this->create($user, $solicitud); 
    }

    /**
     * Determine whether the user can delete the solicitud.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Solicitud  $solicitud
     * @return mixed
     */
    public function delete(User $user, Solicitud $solicitud)
    {
        //
        $this->create($user, $solicitud); 
    }

    /**
     * Determine whether the user can restore the solicitud.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Solicitud  $solicitud
     * @return mixed
     */
    public function restore(User $user, Solicitud $solicitud)
    {
        //
        $this->create($user, $solicitud); 
    }

    /**
     * Determine whether the user can permanently delete the solicitud.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Solicitud  $solicitud
     * @return mixed
     */
    public function forceDelete(User $user, Solicitud $solicitud)
    {
        //
        $this->create($user, $solicitud); 
    }
}
