<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Renta;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RentaCreadaInquilinoReferente extends Notification
{
    use Queueable;

    /**
     * The Renta model.
     *
     * @var Renta
     */
    protected $renta;

    /**
     * Create a new notification instance.
     *
     * @param Renta $renta The Renta model.
     *
     * @return void
     */
    public function __construct(Renta $renta)
    {
        $this->renta = $renta;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $inmueble = $this->renta->idInmueble;
        $unidad = $this->renta->idUnidad;

        if ($unidad) {
            $line = 'Se te asignó un contrato de renta para la Unidad "'.$unidad->piso.' - '.$unidad->numero.'" del Inmueble "'.$unidad->idInmueblePadre->nombre.'"';
        } else {
            $line = 'Se te asignó un contrato de renta para la inmueble "'.$inmueble->idInmueblePadre->nombre.'"';
        }

        return (new MailMessage)
            ->subject('Se te asignó un contrato de Renta')
            ->greeting('Hola '.$notifiable->idPersona->nombre)
            ->line($line)
            ->action('Ir a "Rentas"', url('/inmuebles/'.$inmueble->id_inmueble_padre.'/rentas'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
