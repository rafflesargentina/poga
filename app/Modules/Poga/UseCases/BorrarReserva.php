<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Evento, User };
//use Raffles\Modules\Poga\Notifications\EventoBorrada;
use Raffles\Modules\Poga\Repositories\EventoRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarReserva
{
    use Dispatchable;

    /**
     * The Evento and User models.
     *
     * @var Evento $evento
     * @var User     $user
     */
    protected $evento, $user;

    /**
     * Create a new job instance.
     *
     * @param Evento $evento The Evento model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Evento $evento, User $user)
    {
        $this->evento = $evento;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param EventoRepository $repository The EventoRepository object.
     *
     * @return Evento
     */
    public function handle(EventoRepository $repository)
    {
        $evento = $repository->update($this->evento->id, ['enum_estado' => 'INACTIVO'])[1];

        //$this->user->notify(new EventoBorrada($this->evento, $this->user));

        return $evento;
    }
}
