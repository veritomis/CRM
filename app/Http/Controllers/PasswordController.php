<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class honorarioMensual extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $nombreT;
    public $honorario;
    public $id;
    public $valor;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $nombreT, $honorario, $id, $valor, $pdfPath)
    {
        $this->email = $email;
        $this->nombreT = $nombreT;
        $this->honorario = $honorario;
        $this->id = $id;
        $this->valor = $valor;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificacion de Honorario Mensual')
            ->view('emails.honorarioMensual')
            ->attach($this->pdfPath, ['as' => 'detalles_impuestos.pdf', 'mime' => 'application/pdf']);
    }
}