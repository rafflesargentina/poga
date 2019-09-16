<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, User };
use Raffles\Modules\Poga\Notifications\InmuebleBorrado;
use Raffles\Modules\Poga\Repositories\InmuebleRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarInmueble
{
    use Dispatchable;

    /**
     * The Inmueble and User models.
     *
     * @var Inmueble
     * @var User
     */
    protected $inmueble, $user;

    /**
     * Create a new job instance.
     *
     * @param  Inmueble $inmueble The Inmueble model.
     * @param  User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Inmueble $inmueble, User $user)
    {
        $this->inmueble = $inmueble;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param  InmuebleRepository $repository The InmuebleRepository object.
     *
     * @return Inmueble
     */
    public function handle(InmuebleRepository $repository)
    {
        $inmueble = $repository->update($this->inmueble, ['enum_estado' => 'INACTIVO'])[1];

        $this->user->notify(new InmuebleBorrado($inmueble, $this->user));

        return $inmueble;
    }
}
