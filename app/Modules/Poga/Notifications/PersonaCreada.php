<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Persona;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PersonaCreada extends Notification
{
    use Queueable;

    /**
     * The Persona model.
     *
     * @var Persona $persona
     */
    protected $persona;

    /**
     * Create a new notification instance.
     *
     * @param Persona  $persona The Persona model.
     *
     * @return void
     */
    public function __construct(Persona $persona)
    {
        $this->persona = $persona;
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
        $persona = $this->persona;

        return (new MailMessage)
                    ->subject('Tenés una invitación pendiente')
                    ->greeting('Hola '.$persona->nombre)
                    ->line('Tenés una invitación pendiente para formar parte de POGA.')
                    ->action('Ir a "Completar Registro"', url('/registro-invitado/'.$persona->user->codigo_validacion));
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
