<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Pagare;
use Raffles\Modules\Poga\Notifications\EstadoPagareActualizado;
use Raffles\Modules\Poga\Repositories\PagareRepository;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarEstadoPagare
{
    use DispatchesJobs;

    /**
     * The Pagare model.
     *
     * @var Pagare
     */
    protected $pagare;

    /**
     * El estado del pagaré.
     *
     * @var string $estado
     */
    protected $estado;

    /**
     * Create a new job instance.
     *
     * @param  Pagare $pagare The Pagare model.
     * @param  string $estado El estado del pagaré.
     *
     * @return void
     */
    public function __construct(Pagare $pagare, $estado)
    {
	$this->pagare = $pagare;
        $this->estado = $estado;
    }

    /**
     * Execute the job.
     *
     * @param PagareRepository $rPagare The PagareRepository object.
     *
     * @return void
     */
    public function handle(PagareRepository $repository)
    {
	$pagare = $repository->update($this->pagare, ['enum_estado' => $this->estado])[1];

        $administrador = $pagare->idInmueble->idAdministradorReferente->idPersona->user;
        $acreedor = $pagare->idPersonaAcreedora->user;
        $deudor = $pagare->idPersonaDeudora->user;

        $administrador->notify(new EstadoPagareActualizado($pagare));

        if ($acreedor) {
            $acreedor->notify(new EstadoPagareActualizado($pagare));
        }

        if ($deudor) {
            $deudor->notify(new EstadoPagareActualizado($pagare));
        }

        return $pagare;
    }
}
