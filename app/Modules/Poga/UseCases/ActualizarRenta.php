<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\RentaActualizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarRenta
{
    use DispatchesJobs;
    
    /**
     * The Renta model.
     *
     * @var Renta
     */
    protected $renta;

    /**
     * The form data and User model.
     *
     * @var array
     * @var User
     */
    protected $data, $user;

    /**
     * Create a new job instance.
     *
     * @param Renta $renta The Renta model.
     * @param array $data  The form data.
     * @param User  $user  The User model.
     *
     * @return void
     */
    public function __construct($renta, $data, $user)
    {
        $this->renta = $renta;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param RentaRepository $rRenta The RentaRepository object.
     *
     * @return void
     */
    public function handle(RentaRepository $rRenta)
    {
        $this->authorize('update', $this->renta);

        $renta = $this->actualizarRenta($rRenta);

        $this->user->notify(new RentaActualizada($renta));

        return $renta;
    }

    /**
     * Actualizar Renta.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return \Raffles\Modules\Poga\Models\Renta
     */
    protected function actualizarRenta(RentaRepository $repository)
    {
        return $repository->update($this->renta, $this->data)[1];
    }
}
