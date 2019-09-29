<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Espacio, User };
//use Raffles\Modules\Poga\Notifications\EspacioBorrada;
use Raffles\Modules\Poga\Repositories\EspacioRepository;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BorrarEspacio
{
    use Dispatchable,AuthorizesRequests;

    /**
     * The Espacio and User models.
     *
     * @var Espacio $espacio
     * @var User     $user
     */
    protected $espacio, $user;

    /**
     * Create a new job instance.
     *
     * @param Espacio $espacio The Espacio model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Espacio $espacio, User $user)
    {
        $this->espacio = $espacio;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param EspacioRepository $repository The EspacioRepository object.
     *
     * @return Espacio
     */
    public function handle(EspacioRepository $repository)
    {
        $this->authorize('delete',$this->espacio);

        $espacio = $repository->update($this->espacio->id, ['enum_estado' => 'INACTIVO'])[1];

        //$this->user->notify(new EspacioBorrada($this->espacio, $this->user));

        return $espacio;
    }
}
