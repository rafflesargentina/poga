<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\{ RentaRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\RentaCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearRenta
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
    public function handle(RentaRepository $rRenta, UnidadRepository $rUnidad)
    {
        $renta = $this->crearRenta($rRenta, $rUnidad);

        $this->user->notify(new RentaCreada($renta, $this->user));

        return $renta;
    }

    /**
     * @param RentaRepository $repository The RentaRepository object.
     */
    protected function crearRenta(RentaRepository $repository, UnidadRepository $rUnidad)
    {
        $idUnidad = $this->data['id_unidad'];
        if ($idUnidad) {
            $unidad = $rUnidad->find($idUnidad)->first();
            $this->data['id_inmueble'] = $unidad->id_inmueble;
        }

        return $repository->create(array_merge($this->data,
            [
                //Agregando campos que no se piden en el formulario
                'enum_estado' => 'PENDIENTE',
            ]
        ))[1];
    }
}
