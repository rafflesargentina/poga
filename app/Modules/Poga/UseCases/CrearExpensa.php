<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Inmueble;
use Raffles\Modules\Poga\Repositories\PagareRepository;
use Raffles\Modules\Poga\Repositories\InmuebleRepository;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearExpensa
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
     * @param RentaRepository $rRenta The RentaRepository object.
     *
     * @return void
     */
    public function handle(PagareRepository $rPagare)
    {
        $expensa = $this->crearExpensa($rPagare,$rInmueble); 
        return $expensa;
    }

    /**
     * @param RentaRepository $repository The RentaRepository object.
     */
    protected function crearExpensa(PagareRepository $rPagare)
    {
        $idInmueble = $this->data['id_unidad'];
        if ($idUnidad) 
            $idInmueble = $this->data['id_inmueble'];
        
        return $repository->create($this->data)[1];
    }
}