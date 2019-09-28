<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Raffles\Modules\Poga\Notifications\RentaBorrada;
use Raffles\Modules\Poga\Repositories\RentaRepository;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BorrarRenta
{
    use Dispatchable;

    /**
     * The Renta and User models.
     *
     * @var Renta
     */
    protected $renta, $user;

    /**
     * Create a new job instance.
     *
     * @param Renta $renta The Renta model.
     * @param User  $user  The User model.
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
        $this->authorize('delete',$this->renta);

        $repository->update($this->renta, ['enum_estado' => 'INACTIVO'])[1];

        $this->user->notify(new RentaBorrada($this->renta));

        return $this->renta;
    }
}
