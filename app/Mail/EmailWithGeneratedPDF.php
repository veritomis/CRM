<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailWithGeneratedPDF extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;
    public $destinatario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($destinatario, $pdfPath)
    {
        $this->destinatario = $destinatario;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {

        return $this->subject('Asunto del Correo')
            ->view('emails.example') // Esto podría ser la vista del correo electrónico
            ->attach($this->pdfPath, ['as' => 'cotizacionARG.pdf', 'mime' => 'application/pdf']);

        return redirect()->back()->with('mensaje', 'Correo enviado con éxito.');
    }
}
