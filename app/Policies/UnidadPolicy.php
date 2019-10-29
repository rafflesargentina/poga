<?php

namespace Raffles\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Unidad;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnidadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Unidad  $unidad
     * @return mixed
     */
    public function view(User $user, Unidad $unidad)
    {
        //
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
    }

    /**
     * Determine whether the user can update the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Unidad  $unidad
     * @return mixed
     */
    public function update(User $user, Unidad $unidad)
    {
        //
    }

    /**
     * Determine whether the user can delete the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Unidad  $unidad
     * @return mixed
     */
    public function delete(User $user, Unidad $unidad)
    {
        //
    }

    /**
     * Determine whether the user can restore the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Unidad  $unidad
     * @return mixed
     */
    public function restore(User $user, Unidad $unidad)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the unidad.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Unidad  $unidad
     * @return mixed
     */
    public function forceDelete(User $user, Unidad $unidad)
    {
        //
    }
}
