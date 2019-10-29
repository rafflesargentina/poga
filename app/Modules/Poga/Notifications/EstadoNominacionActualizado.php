<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Nominacion;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EstadoNominacionActualizado extends Notification
{
    use Queueable;

    /**
     * The Nominacion model.
     *
     * @var Nominacion
     */
    protected $nominacion;

    /**
     * Create a new notification instance.
     *
     * @param Nominacion $nominacion The Nominacion model.
     *
     * @return void
     */
    public function __construct(Nominacion $nominacion)
    {
        $this->nominacion = $nominacion;
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
	$nominacion = $this->nominacion;
	$estado = $nominacion->enum_estado;
	$inmueble = $nominacion->idInmueble;
	$unidad = $nominacion->idUnidad;
	$rol = $nominacion->idRolNominado->name;

        if ($unidad) {
	    $line = 'El estado de la nominación para el rol '.$rol.' fue actualizado a '.$estado.', para la Unidad "Piso: '.$unidad->piso.' - '.$unidad->numero.'" del Inmueble "'.$unidad->idInmueblePadre->nombre;
        } else {
            $line = 'El estado de la nominación para el rol '.$rol.' fue actualizado a '.$estado.', para el inmueble "'.$inmueble->idInmueblePadre->nombre.'"';
	}

        return (new MailMessage)
            ->subject('El estado de una nominación fue actualizado')
            ->greeting('Hola '.$notifiable->idPersona->nombre)
	    ->line($line)
            ->action('Ir a "Nominaciones"', url('inmuebles/'.$inmueble->id_inmueble_padre.'/nominaciones'));
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
