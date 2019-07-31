<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\{ Inmueble, User };

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InmuebleCreado extends Notification
{
    use Queueable;

    /**
     * The Inmueble and User models.
     *
     * @var Inmueble $inmueble
     * @var User     $user
     */
    protected $inmueble, $user;

    /**
     * Create a new notification instance.
     *
     * @param Inmueble  $inmueble The Inmueble model.
     * @param User      $user     The User model.
     *
     * @return void
     */
    public function __construct(Inmueble $inmueble, User $user)
    {
        $this->inmueble = $inmueble;
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
        return (new MailMessage)
                    ->subject('Agregaste un nuevo Inmueble a nuestros registros')
                    ->greeting('Hola '.$this->user->idPersona->nombre)
                    ->line('Creaste el inmueble nombrado "'.$this->inmueble->idInmueblePadre->nombre.'"')
                    ->action('Ir a "Mis Inmuebles"', url('/inmuebles/mis-inmuebles'));
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
