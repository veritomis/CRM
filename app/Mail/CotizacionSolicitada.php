<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CotizacionSolicitada extends Mailable
{
    use Queueable, SerializesModels;


    public $nombreC;
    public $nombreU;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreC, $nombreU)
    {
        $this->nombreC = $nombreC;
        $this->nombreU = $nombreU;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitud de Cotización')
            ->view('emails.cotizacion_solicitada');
    }
}