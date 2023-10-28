<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $name;
    public $apellido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $apellido)
    {
        $this->name = $name;
        $this->email = $email;
        $this->apellido = $apellido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Establecer Contraseña')
            ->view('emails.crearCuenta');
    }
}
