<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Evento, User };
use Raffles\Modules\Poga\Repositories\EventoRepository;
//use Raffles\Modules\Poga\Notifications\EventoActualizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarReserva
{
    use DispatchesJobs;

    /**
     * The Evento model.
     *
     * @var Evento $evento
     */
    protected $evento;

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
    public function __construct(Evento $evento, $data, User $user)
    {
        $this->evento = $evento;
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
        $evento = $this->actualizarepository($repository);

        $this->actualizarInvitados($evento);

        //$this->user->notify(new EventoActualizada($evento, $this->user));

        return $evento;
    }

    /**
     * @param EventoRepository $repository The EventoRepository object.
     */
    protected function actualizarepository(EventoRepository $repository)
    {
        return $repository->update($this->evento, $this->data)[1];
    }

    /**
     * @param Evento $evento The Evento model.
     */
    protected function actualizarInvitados($evento)
    {
        $invitados = $this->data['invitados'];

        $notPresent = array_map(function($evento) { 
            return array_key_exists('id', $evento) ? $evento['id'] : null;
        }, $invitados);

        $evento->invitados()->whereNotIn('id', $notPresent)->get()->each(function($item) { return $item->delete(); });

        foreach ($invitados as $invitado) {
            $evento->invitados()->updateOrCreate(['id' => (array_key_exists('id', $invitado) ? $invitado['id'] : null)], $invitado);
        }
    }
}
