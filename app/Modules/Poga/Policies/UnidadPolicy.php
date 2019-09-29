<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Unidad;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnidadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Unidad  $unidad
     * @return mixed
     */
    public function view(User $user, Unidad $unidad)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create unidads.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Unidad  $unidad
     * @return mixed
     */
    public function update(User $user, Unidad $unidad)
    {
        $inmueble = $unidad->idInmueble;     

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
                return $inmueble->inquilinos->where('id', $user->id_persona);
            
            // Propietario
            case 4:
                
                return $inmueble->propietarios->where('id', $user->id_persona);
    
            // Proveedor
            case 5:
                    return false;
        
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Unidad  $unidad
     * @return mixed
     */
    public function delete(User $user, Unidad $unidad)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can restore the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Unidad  $unidad
     * @return mixed
     */
    public function restore(User $user, Unidad $unidad)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can permanently delete the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Unidad  $unidad
     * @return mixed
     */
    public function forceDelete(User $user, Unidad $unidad)
    {
        //
        return true;
    }
}
