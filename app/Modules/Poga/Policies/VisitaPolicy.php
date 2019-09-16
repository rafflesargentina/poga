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
    }

    /**
     * Determine whether the user can create visitas.
     *
     * @param  \Raffles\Modules\Poga\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
        //
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
    }
}
