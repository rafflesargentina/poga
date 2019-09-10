<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Evento, User };
//use Raffles\Modules\Poga\Notifications\EventoBorrada;
use Raffles\Modules\Poga\Repositories\EventoRepository;

use Illuminate\Foundation\Bus\Dispatchable;

class BorrarVisita
{
    use Dispatchable;

    /**
     * The Evento and User models.
     *
     * @var Evento $visita
     * @var User     $user
     */
    protected $visita, $user;

    /**
     * Create a new job instance.
     *
     * @param Evento $visita The Evento model.
     * @param User     $user     The User model.
     *
     * @return void
     */
    public function __construct(Evento $visita, User $user)
    {
        $this->visita = $visita;
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
        $visita = $repository->update($this->visita->id, ['enum_estado' => 'INACTIVO'])[1];

        //$this->user->notify(new EventoBorrada($this->visita, $this->user));

        return $visita;
    }
}
