<?php

namespace Raffles\Modules\Poga\Policies;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Models\Inmueble;
use Illuminate\Auth\Access\HandlesAuthorization;

class InmueblePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function view(User $user, Inmueble $inmueble)
    {
        //
    }

    /**
     * Determine whether the user can create inmuebles.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function update(User $user, Inmueble $inmueble)
    {
        //
    }

    /**
     * Determine whether the user can delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function delete(User $user, Inmueble $inmueble)
    {
        //
    }

    /**
     * Determine whether the user can restore the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function restore(User $user, Inmueble $inmueble)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the inmueble.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @param  \Raffles\Modules\Poga\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function forceDelete(User $user, Inmueble $inmueble)
    {
        //
    }
}
