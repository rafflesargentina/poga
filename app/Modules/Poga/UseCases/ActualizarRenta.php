<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\RentaActualizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarRenta
{
    use DispatchesJobs;

    /**
     * The form data, the Renta id, and the User model.
     *
     * @var int   $id
     * @var array $data
     * @var User  $user
     */
    protected $id, $data, $user;

    /**
     * Create a new job instance.
     *
     * @param int   $id   The Renta id.
     * @param array $data The form data.
     * @param User  $user The User model.
     *
     * @return void
     */
    public function __construct($id, $data, $user)
    {
        $this->id = $id;
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
        $renta = $this->actualizarRenta($rRenta);

        $this->user->notify(new RentaActualizada($renta, $this->user));

        return $renta;
    }

    /**
     * @param RentaRepository $repository The RentaRepository object.
     */
    protected function actualizarRenta(RentaRepository $repository)
    {
        return $repository->update($this->id, $this->data)[1];
    }
}
