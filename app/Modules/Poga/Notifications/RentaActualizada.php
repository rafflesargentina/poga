<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\{ Renta, User };

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RentaActualizada extends Notification
{
    use Queueable;

    /**
     * The Inmueble and User models.
     *
     * @var Renta $renta
     * @var User     $user
     */
    protected $renta, $user;

    /**
     * Create a new notification instance.
     *
     * @param Renta  $renta The Renta model.
     * @param User      $user     The User model.
     *
     * @return void
     */
    public function __construct(Renta $renta, User $user)
    {
        $this->renta = $renta;
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
                    ->subject('Actualizaste un contrato de Renta')
                    ->greeting('Hola '.$this->user->idPersona->nombre)
                    ->line('Actualizaste el contrato de renta para del inquilino '.$this->renta->idPersona->nombre.'.')
                    ->action('Ir a "Rentas"', url('/inmuebles/'.$this->renta->idInmueble->id_inmueble_padre.'/rentas'));
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
