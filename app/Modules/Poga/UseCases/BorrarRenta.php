<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Raffles\Modules\Poga\Notifications\RentaBorrada;
use Raffles\Modules\Poga\Repositories\RentaRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarRenta
{
    use Dispatchable;

    /**
     * The Unidad and User models.
     *
     * @var Renta $unidad
     * @var User     $user
     */
    protected $renta, $user;

    /**
     * Create a new job instance.
     *
     * @param Renta $unidad The Unidad model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Renta $renta, User $user)
    {
        $this->renta = $renta;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return Renta
     */
    public function handle(RentaRepository $repository)
    {
        $repository->update($this->renta->id, ['enum_estado' => 'INACTIVO'])[1];

        $this->user->notify(new RentaBorrada($this->renta, $this->user));

        return $this->renta;
    }
}