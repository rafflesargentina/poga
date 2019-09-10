<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Persona;
use Raffles\Modules\Poga\Repositories\{ PersonaRepository, UserRepository };

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarPersona
{
    use DispatchesJobs;

    /**
     * The Persona model.
     *
     * @var Persona $persona
     */
    protected $persona;

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
    public function __construct(Persona $persona, $data, $user)
    {
        $this->persona = $persona;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param Persona           $persona    The Persona $persona.
     * @param PersonaRepository $repository The PersonaRepository object.
     * @param UserRepository    $rUser      The UserRepository object.
     *
     * @return void
     */
    public function handle(PersonaRepository $repository, UserRepository $rUser)
    {
        $persona = $this->actualizarPersona($repository);

        return $persona;
    }

    /**
     * @param PersonaRepository $repository The PersonaRepository object.
     */
    protected function actualizadaPersona(PersonaRepository $repository)
    {
        return $repository->update($this->persona, $this->data);
    }
}
