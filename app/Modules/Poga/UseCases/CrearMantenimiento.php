<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\User;
use Raffles\Modules\Poga\Repositories\MantenimientoRepository;
use Raffles\Modules\Poga\Notifications\MantenimientoCreado;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearMantenimiento
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
     * @param  MantenimientoRepository $repository The MantenimientoRepository object.
     *
     * @return void
     */
    public function handle(MantenimientoRepository $repository)
    {
	$data = $this->data;

    }
}
