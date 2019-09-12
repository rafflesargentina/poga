<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ InmueblePersona, User };
use Raffles\Modules\Poga\Repositories\InmueblePersonaRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarInmueblePersona
{
    use Dispatchable;

    /**
     * The InmueblePersona and User models.
     *
     * @var InmueblePersona
     * @var User
     */
    protected $inmueblePersona, $user;

    /**
     * Create a new job instance.
     *
     * @param InmueblePersona $persona The InmueblePersona model.
     * @param User            $user    The User model.
     *
     * @return void
     */
    public function __construct(InmueblePersona $inmueblePersona, User $user)
    {
        $this->inmueblePersona = $inmueblePersona;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param InmueblePersonaRepository $repository The InmueblePersonaRepository object.
     *
     * @return InmueblePersona
     */
    public function handle(InmueblePersonaRepository $repository)
    {
        $inmueblePersona = $repository->update($this->inmueblePersona->id, ['enum_estado' => 'INACTIVO'])[1];

        return $inmueblePersona;
    }
}
