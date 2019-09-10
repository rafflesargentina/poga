<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\Evento;
use Raffles\Modules\Poga\Repositories\EventoRepository;

use Illuminate\Foundation\Bus\DispatchesJobs;

class CrearReserva
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
     * @param EventoRepository $repository The EventoRepository object.
     *
     * @return void
     */
    public function handle(EventoRepository $repository)
    {
        $evento = $this->crearReserva($repository);
        $this->crearInvitados($evento);

        return $evento;
    }

    /**
     * @param EventoRepository $repository The EventoRepository object.
     */
    protected function crearReserva(EventoRepository $repository)
    {
        return $repository->create(array_merge($this->data,
            [
                'enum_estado' => 'ACTIVO',
                'enum_tipo_evento' => 'RESERVA',
                'id_usuario_creador' => $this->user->id,
            ]
        ))[1];
    }

    /**
     * @param Evento $evento The Evento model.
     */
    protected function crearInvitados(Evento $evento)
    {
        $invitados = $this->data['invitados'];

        foreach ($invitados as $invitado) {
            $evento->invitados()->create($invitado);
        }
    }
}
