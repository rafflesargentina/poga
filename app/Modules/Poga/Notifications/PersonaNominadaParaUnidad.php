<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\{ Persona, Nominacion, Unidad };

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PersonaNominadaParaUnidad extends Notification
{
    use Queueable;

    /**
     * The Persona and Nominacion models.
     *
     * @var Persona    $persona
     * @var Nominacion $nominacion
     * @var Unidad     $unidad
     */
    protected $persona, $nominacion, $unidad;

    /**
     * Create a new notification instance.
     *
     * @param Persona    $persona     The Persona model.
     * @param Nominacion $nominacion  The Nominacion model.
     * @param Unidad     $unidad      The Unidad model.
     *
     * @return void
     */
    public function __construct(Persona $persona, Nominacion $nominacion, Unidad $unidad)
    {
        $this->persona = $persona;
        $this->nominacion = $nominacion;
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
        $rol = $this->nominacion->idRolNominado->name;

        return (new MailMessage)
                    ->subject('Fuiste nominado como '.$rol)
                    ->greeting('Hola '.$this->persona->nombre)
                    ->line('Fuiste nominado como '.$rol.' para la Unidad "'.$this->unidad->numero.'" del Inmueble "'.$inmueblePadre->nombre.'"')
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
