<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\{ PagareRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\RentaCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CrearPagare
{
    use DispatchesJobs,AuthorizesRequests;

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
        
       
        $this->authorize('create', new Pagare);

        $renta = $this->crearPagare($rPagare, $rUnidad);

        return $renta;
    }

    /**
     *  @param PagareRepository $rPagare The PagareRepository object.
     */
    protected function crearPagare(PagareRepository $rPagare, UnidadRepository $rUnidad)
    {
       

        $idUnidad = $this->data['id_unidad'];
        if ($idUnidad) {
            $unidad = $rUnidad->find($idUnidad)->first();
            $this->data['id_inmueble'] = $unidad->id_inmueble;
        }

        return $rPagare->create($this->data)[1];
    }
}
