<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Renta, User };
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\RentaFinalizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class FinalizarContratoRenta
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
        $renta = $this->finalizarRenta($rRenta);

        $this->user->notify(new RentaFinalizada($renta));

        return $renta;
    }

    /**
     * Finalizar Renta.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return \Raffles\Modules\Poga\Models\Renta
     */
    protected function finalizarRenta(RentaRepository $repository)
    {
        return $repository->update(
            $this->renta, array_merge(
                $this->data,
                [
                'enum_estado' => 'FINALIZADO',
                ]
            )
        )[1];
    }
}
