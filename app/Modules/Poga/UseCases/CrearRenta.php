<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Unidad, User };
use Raffles\Modules\Poga\Repositories\RentaRepository;
use Raffles\Modules\Poga\Notifications\UnidadCreada;

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
     * @param InmuebleRepository      $rInmueble      The InmuebleRepository object.
     * @param UnidadRepository        $rUnidad        The UnidadRepository object.
     * @param PersonaRepository       $rPersona       The PersonaRepository object.
     *
     * @return void
     */
    public function handle(RentaRepository $rRenta)
    {
        $this->crearRenta($rRenta);
    }

    /**
     * @param RentaRepository $repository The RentaRepository object.
     */
    protected function crearRenta(RentaRepository $repository)
    {
        return $repository->create(array_merge($this->data,
            [
                //Agregando campos que no se piden en el formulario
                'enum_estado' => 'ACTIVO',
            ]
        ))[1];
    }

   
    protected function crearPagare()
    {
       
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Unidad            $unidad     The Unidad model.
     */
    protected function nominarAdministrador(PersonaRepository $repository, Unidad $unidad)
    {
        $id = $this->data['idAdministradorReferente'];

        if ($id) {

            $persona = $repository->find($id)->first();

            $this->dispatch(new NominarAdministradorReferenteParaUnidad($persona, $unidad));
        }
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param Unidad            $unidad     The Unidad model.
     */
    protected function nominarPropietario(PersonaRepository $repository, Unidad $unidad)
    {
        $id = $this->data['idPropietarioReferente'];

        if ($id) {

            $persona = $repository->find($id)->first();

            $this->dispatch(new NominarPropietarioReferenteParaUnidad($persona, $unidad));
        }
    }
}
