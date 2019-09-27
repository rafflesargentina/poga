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
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $mantenimiento
     * @return mixed
     */
    public function view(User $user, Mantenimiento $mantenimiento)
    {
        $this->create($user, $mantenimiento);   
    }

    /**
     * Determine whether the user can create mantenimientos.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Mantenimiento $mantenimiento)
    {
        //
        $inmueble = $mantenimiento->idInmueble;     

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
                return $inmueble->inquilinos->where('id', $user->id_persona)
                && $inmueble->solicitud_directa_inquilinos;
                break;	
            
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
     * Determine whether the user can update the mantenimiento.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $mantenimiento
     * @return mixed
     */
    public function update(User $user, Mantenimiento $mantenimiento)
    {
        //
        $this->create($user, $mantenimiento);   
    }

    /**
     * Determine whether the user can delete the mantenimiento.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $mantenimiento
     * @return mixed
     */
    public function delete(User $user, Mantenimiento $mantenimiento)
    {
        //
        $this->create($user, $mantenimiento); 
    }

    /**
     * Determine whether the user can restore the mantenimiento.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $mantenimiento
     * @return mixed
     */
    public function restore(User $user, Mantenimiento $mantenimiento)
    {
        //
        $this->create($user, $mantenimiento); 
    }

    /**
     * Determine whether the user can permanently delete the mantenimiento.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Mantenimiento  $mantenimiento
     * @return mixed
     */
    public function forceDelete(User $user, Mantenimiento $mantenimiento)
    {
        //
        $this->create($user, $mantenimiento); 
    }
}
