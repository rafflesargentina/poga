<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UsuarioRegistrado extends Notification
{
    use Queueable;

    /**
     * The Inmueble and User models.
     *
     * @var User     $user
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user The User model.
     *
     * @return void
     */
    public function __construct(User $user)
    {
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
                    ->subject('Fuiste registrado en POGA')
                    ->greeting('Hola '.$this->user->idPersona->nombre)
                    ->line('Fuiste registrado en POGA')
                    ->action('Ir a "Login"', url('/'));
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
