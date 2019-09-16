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
    }

    /**
     * Determine whether the user can create solicituds.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
    }
}
