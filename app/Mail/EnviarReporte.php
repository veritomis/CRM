<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarReporte extends Mailable
{
    use Queueable, SerializesModels;

    public $html;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    public function build()
    {
        return $this->view('emails.reporte')
                    ->subject('Reporte Diario')
                    ->with('html', $this->html);
    }
}
