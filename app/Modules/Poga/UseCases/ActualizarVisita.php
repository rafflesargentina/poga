<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Evento, User };
use Raffles\Modules\Poga\Repositories\EventoRepository;
//use Raffles\Modules\Poga\Notifications\EventoActualizada;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ActualizarVisita
{
    use DispatchesJobs;

    /**
     * The Evento model.
     *
     * @var Evento $visita
     */
    protected $visita;

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
    public function __construct(Evento $visita, $data, User $user)
    {
        $this->visita = $visita;
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
        $visita = $this->actualizarepository($repository);

        $this->actualizarInvitados($visita);

        //$this->user->notify(new EventoActualizada($visita, $this->user));

        return $visita;
    }

    /**
     * @param EventoRepository $repository The EventoRepository object.
     */
    protected function actualizarepository(EventoRepository $repository)
    {
        return $repository->update($this->visita, $this->data)[1];
    }

    /**
     * @param Evento $visita The Evento model.
     */
    protected function actualizarInvitados($visita)
    {
        $invitados = $this->data['invitados'];

        $notPresent = array_map(function($visita) { 
            return array_key_exists('id', $visita) ? $visita['id'] : null;
        }, $invitados);

        $visita->invitados()->whereNotIn('id', $notPresent)->get()->each(function($item) { return $item->delete(); });

        foreach ($invitados as $invitado) {
            $visita->invitados()->updateOrCreate(['id' => (array_key_exists('id', $invitado) ? $invitado['id'] : null)], $invitado);
        }
    }
}
