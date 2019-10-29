<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Repositories\{ InmuebleRepository, PersonaRepository, RentaRepository, UnidadRepository };
use Raffles\Modules\Poga\Notifications\{ RentaCreada, RentaCreadaPropietarioReferente, RentaCreadaInquilinoReferente };

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearRenta
{
    use DispatchesJobs;

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
     * @param  RentaRepository   $rRenta   The RentaRepository object.
     * @param  PersonaRepository $rPersona The PersonaRepository object.
     *
     * @return void
     */
    public function handle(RentaRepository $rRenta, PersonaRepository $rPersona, UnidadRepository $rUnidad, InmuebleRepository $rInmueble)
    {
	$data = $this->data;

        $inquilino = $rPersona->findOrFail($data['id_inquilino']);
        if (!$inquilino->user) {
            $estado = 'ACTIVO';
        } else {
            $estado = 'PENDIENTE';
	}

	$idUnidad = $data['id_unidad'];

        // id_unidad no está vacío?
        if ($idUnidad) {
            $unidad = $rUnidad->findOrFail($idUnidad);
	    $data['id_inmueble'] = $unidad->id_inmueble;

	    // Nomina al inquilino referente para la unidad.
	    $this->dispatchNow(new NominarInquilinoReferenteParaUnidad($inquilino, $unidad, $this->user));
	} else {
	    $inmueble = $rInmueble->findOrFail($data['id_inmueble']);
            // Nomina al inquilino referente para el condominio.
            $this->dispatchNow(new NominarInquilinoReferenteParaInmueble($inquilino, $inmueble, $this->user));
	}

        $renta = $rRenta->create(
            array_merge(
                $data,
                [
                // Agrega campos que no se piden en el formulario.
                'enum_estado' => $estado,
                ]
            )
        )[1];

	// Si el inquilino no completó su registro.
	if (!$inquilino->user) {
	    $this->dispatchNow(new GenerarComisionPrimerMesAdministrador($renta));
	    $this->dispatchNow(new GenerarPagareRentaPrimerMes($renta));
	} else {
            // Notifica al inquilino.
	    $inquilino->user->notify(new RentaCreadaInquilinoReferente($renta));
	}

	// Notifica al administrador.
	$this->user->notify(new RentaCreada($renta));

	// Notifica al propietario.
	$propietario = $renta->idInmueble->idPropietarioReferente->idPersona;
	if ($propietario->user) {
            $propietario->user->notify(new RentaCreadaPropietarioReferente($renta));
	}

	return $renta;
    }
}
