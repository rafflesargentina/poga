<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Unidad;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UnidadAsignada extends Notification
{
    use Queueable;

    /**
     * The Unidad model.
     *
     * @var Unidad $unidad
     */
    protected $unidad;

    /**
     * Create a new notification instance.
     *
     * @param Unidad  $unidad The Unidad model.
     *
     * @return void
     */
    public function __construct(Unidad $unidad)
    {
        $this->unidad = $unidad;
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
                    ->subject('Fuiste asignado como Propietario de una Unidad de nuestros registros')
                    ->greeting('Hola '.$notifiable->idPersona->nombre)
                    ->line('Te asignaron la unidad "'.$this->unidad->numero.'" para el inmueble "'.$inmueblePadre->nombre.'"')
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
