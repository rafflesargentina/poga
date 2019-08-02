<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\{ Unidad, User };

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UnidadCreada extends Notification
{
    use Queueable;

    /**
     * The Unidad and User models.
     *
     * @var Unidad $unidad
     * @var User     $user
     */
    protected $unidad, $user;

    /**
     * Create a new notification instance.
     *
     * @param Unidad  $unidad The Unidad model.
     * @param User      $user     The User model.
     *
     * @return void
     */
    public function __construct(Unidad $unidad, User $user)
    {
        $this->unidad = $unidad;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $inmueblePadre = $this->unidad->idInmueblePadre;

        return (new MailMessage)
                    ->subject('Agregaste un nuevo Unidad a nuestros registros')
                    ->greeting('Hola '.$this->user->idPersona->nombre)
                    ->line('Creaste la unidad "'.$this->unidad->numero.'" para el inmueble "'.$inmueblePadre->nombre.'"')
                    ->action('Ir a "Unidades de Inmueble"', url('/inmuebles/'.$inmueblePadre->id.'/unidades'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
