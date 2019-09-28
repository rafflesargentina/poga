<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Repositories\{ RentaRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\RentaCreada;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CrearRenta
{
    use DispatchesJobs,AuthorizesRequests;

    /**
     * The form data and the User model.
     *
     * @var array
     * @var User
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
    public function __construct($data, User $user)
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
        $this->authorize('create', new Renta);

        $renta = $this->crearRenta($rRenta, $rUnidad);

        $this->user->notify(new RentaCreada($renta));

        return $renta;
    }

    /**
     * Crear Renta.
     *
     * @param RentaRepository $repository The RentaRepository object.
     *
     * @return Renta
     */
    protected function crearRenta(RentaRepository $repository, UnidadRepository $rUnidad)
    {
        // id_unidad existe en el array?    
        if (array_key_exists('id_unidad', $this->data)) {
            $idUnidad = $this->data['id_unidad'];

            // id_unidad no está vacío?
            if ($idUnidad) {
                $unidad = $rUnidad->findOrFail($idUnidad);
                $this->data['id_inmueble'] = $unidad->id_inmueble;
            }
        }

        return $repository->create(
            array_merge(
                $this->data,
                [
                // Agrega campos que no se piden en el formulario.
                'enum_estado' => 'PENDIENTE',
                ]
            )
        )[1];
    }
}
