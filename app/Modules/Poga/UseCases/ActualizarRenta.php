<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\RentaActualizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarRenta
{
    use DispatchesJobs;
    
    /**
     * The form data, the Renta model id, and the User model.
     *
     * @var int   
     * @var array
     * @var User
     */
    protected $id, $data, $user;

    /**
     * Create a new job instance.
     *
     * @param int   $id   The Renta model id.
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
        return $repository->update($this->id, $this->data)[1];
    }
}
