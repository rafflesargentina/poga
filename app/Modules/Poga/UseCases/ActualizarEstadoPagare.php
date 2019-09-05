<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\{ PagareRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\RentaCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarEstadoPagare
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
        $pagare = $this->rPagare->actualizarEstado($this->data['idPagare'],$this->data['enum_estado']);
        return $pagare;
    }

    
}