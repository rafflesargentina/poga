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
        //
    }

    /**
     * Determine whether the user can create mantenimientos.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
    }
}
