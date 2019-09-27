<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Evento;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the visita.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Evento $evento
     * @return mixed
     */
    public function view(User $user, Evento $evento)
    {
        //
        $inmueble = $evento->idInmueble;  
        switch ($user->role_id) {
            // Administrador
            case 1:                    
                
                switch($evento->enum_tipo_evento){
                    case "VISITA":
                        return $inmueble->administradores->where('id', $user->id_persona)
                        && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                    break;
                }
               
                

            break;
    
            // Conserje
            case 2:
                switch($evento->enum_tipo_evento){
                case "VISITA":
                    return $inmueble->conserjes->where('id', $user->id_persona)
                    && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                break;
                
    
            // Inquilino
            case 3: 
            
                switch($evento->enum_tipo_evento){
                case "VISITA":
                    return $inmueble->inquilinos->where('id', $user->id_persona)
                    && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                break;
            }	
    
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
        $inmueble = $evento->idInmueble;  
        switch ($user->role_id) {
            // Administrador
            case 1:                    
                
                switch($evento->enum_tipo_evento){
                    case "VISITA":
                        return $inmueble->administradores->where('id', $user->id_persona)
                        && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                    break;
                }
               
                

            break;
    
            // Conserje
            case 2:
                   return false;
                break;
    
            // Inquilino
            case 3: 

                switch($evento->enum_tipo_evento){
                case "VISITA":
                    return $inmueble->inquilinos->where('id', $user->id_persona)
                    && $inmueble->enum_tabla_hija == "INMUEBLE_PADRE";
                break;
            }	
    
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
     * @param  \Raffles\Modules\Poga\Models\Evento $evento
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
     * @param  \Raffles\Modules\Poga\Models\Evento $evento
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
     * @param  \Raffles\Modules\Poga\Models\Evento $evento
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
     * @param  \Raffles\Modules\Poga\Models\Evento $evento
     * @return mixed
     */
    public function forceDelete(User $user, Visita $visita)
    {
        //
        $this->create($user, $visita); 
    }
}
