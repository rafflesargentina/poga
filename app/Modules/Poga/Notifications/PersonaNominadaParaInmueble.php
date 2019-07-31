<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\{ Persona, Nominacion };

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PersonaNominadaParaInmueble extends Notification
{
    use Queueable;

    /**
     * The Persona and Nominacion models.
     *
     * @var Persona    $persona
     * @var Nominacion $nominacion
     */
    protected $persona, $nominacion;

    /**
     * Create a new notification instance.
     *
     * @param Persona    $persona     The Persona model.
     * @param Nominacion $nominacion The Nominacion model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Nominacion $nominacion)
    {
        $this->persona = $persona;
        $this->nominacion = $nominacion;
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
        $rol = $this->nominacion->idRolNominado->name;

        return (new MailMessage)
                    ->subject('Fuiste nominado como '.$rol)
                    ->greeting('Hola '.$this->persona->nombre)
                    ->line('Fuiste nominado como '.$rol.' para el inmueble "'.$this->nominacion->idInmueble->idInmueblePadre->nombre.'"')
                    ->action('Ir a "Donde Fui Nominado"', url('/inmuebles/donde-fui-nominado'));
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
