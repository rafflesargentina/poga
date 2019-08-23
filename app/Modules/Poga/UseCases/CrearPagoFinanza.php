<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\{ PagareRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\RentaCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearPagoFinanza
{
    use DispatchesJobs;

    /**
     * The form data and the User model.
     *
     * @var array $data
     * @var User  $user
     */
    protected $data, $user;

    /**
     * Create a new job instance.
     *
     * @param array $data The form data.
     * @param User  $user The User model.
     *
     * @return void
     */
    public function __construct($data,$user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param PagareRepository $rPagare The PagareRepository object.
     *
     * @return void
     */
    public function handle(PagareRepository $rPagare, UnidadRepository $rUnidad)
    {
        $renta = $this->crearPago($rPagare, $rUnidad);

        return $renta;
    }

    /**
     *  @param PagareRepository $rPagare The PagareRepository object.
     */
  


}
