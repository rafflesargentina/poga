<?php

namespace Raffles\Modules\Poga\Notifications;

use Raffles\Modules\Poga\Models\Pagare;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PagareCreadoPersonaAcreedora extends Notification
{
    use Queueable;

    /**
     * The Pagare model.
     *
     * @var Pagare
     */
    protected $pagare;

    /**
     * Create a new notification instance.
     *
     * @param Pagare $pagare The Pagare model.
     *
     * @return void
     */
    public function __construct(Pagare $pagare)
    {
        $this->pagare = $pagare;
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
	$pagare = $this->pagare;
        $inmueble = $pagare->idInmueble;
	$unidad = $pagare->idUnidad;
	$deudor = $pagare->idPersonaDeudora;

        if ($unidad) {
		$line1 = 'Sos acreedor de un pagaré para la Unidad "Piso: '.$unidad->piso.' - '.$unidad->numero.'" del Inmueble "'.$unidad->idInmueblePadre->nombre;
        } else {
            $line1 = 'Sos acreedor de un pagaré para el inmueble "'.$inmueble->idInmueblePadre->nombre.'"';
	}

	$line2 = 'Persona deudora: '.$deudor->nombre_y_apellidos;
	$line3 = 'Tipo: '.$pagare->enum_clasificacion_pagare;
	$line4 = 'Monto: '.$pagare->monto.' '.$pagare->idMoneda->moneda;

        return (new MailMessage)
            ->subject('Sos acreedor de un pagaré')
            ->greeting('Hola '.$notifiable->idPersona->nombre)
	    ->line($line1)
	    ->line($line2)
	    ->line($line3)
	    ->line($line4)
            ->action('Ir a "Finanzas"', url('inmuebles/'.$inmueble->id_inmueble_padre.'/finanzas'));
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
