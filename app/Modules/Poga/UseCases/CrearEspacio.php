<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Repositories\EspacioRepository;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearEspacio
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
     * @param EspacioRepository $repository The EspacioRepository object.
     *
     * @return void
     */
    public function handle(EspacioRepository $repository)
    {
        return $repository->create(array_merge($this->data,
            [
                'enum_estado' => 'ACTIVO',
            ]
        ))[1];
    }
}
