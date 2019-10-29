<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Mantenimiento;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MantenimientoActualizado extends Notification
{
    use Queueable;

    /**
     * The Mantenimiento model.
     *
     * @var Mantenimiento
     */
    protected $mantenimiento;

    /**
     * Create a new notification instance.
     *
     * @param Mantenimiento $mantenimiento The Mantenimiento model.
     *
     * @return void
     */
    public function __construct(Mantenimiento $mantenimiento)
    {
        $this->mantenimiento = $mantenimiento;
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
        $inmueble = $this->mantenimiento->idInmueble;
        $line = 'Actualizaste un mantenimiento para el inmueble "'.$inmueble->idInmueblePadre->nombre.'"';

        return (new MailMessage)
            ->subject('Actualizaste un Mantenimiento')
            ->greeting('Hola '.$notifiable->idPersona->nombre)
            ->line($line)
            ->action('Ir a "Mantenimientos"', url('/inmuebles/'.$inmueble->id_inmueble_padre.'/mantenimientos'));
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
