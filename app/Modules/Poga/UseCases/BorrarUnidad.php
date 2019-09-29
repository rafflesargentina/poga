<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Unidad, User };
use Raffles\Modules\Poga\Notifications\UnidadBorrada;
use Raffles\Modules\Poga\Repositories\InmuebleRepository;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BorrarUnidad
{
    use Dispatchable,AuthorizesRequests;

    /**
     * The Unidad and User models.
     *
     * @var Unidad $unidad
     * @var User     $user
     */
    protected $unidad, $user;

    /**
     * Create a new job instance.
     *
     * @param Unidad $unidad The Unidad model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Unidad $unidad, User $user)
    {
        $this->unidad = $unidad;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param InmuebleRepository $repository The InmuebleRepository object.
     *
     * @return Unidad
     */
    public function handle(InmuebleRepository $repository)
    {
        $inmueble = Inmueble::findOrFail($this->unidad->idInmueble);
        $this->authorize('update',$inmueble);
        
        $repository->update($inmueble, ['enum_estado' => 'INACTIVO'])[1];

        $this->user->notify(new UnidadBorrada($this->unidad, $this->user));

        return $this->unidad;
    }
}
