<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoEjemplo; // Asegúrate de importar tu clase de correo

class EnviarCorreo extends Command
{
    protected $signature = 'correo:enviar';
    protected $description = 'Enviar correo y adjuntar PDF';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lógica para adjuntar el PDF y enviar el correo
        $pdfPath = '/ruta/al/archivo.pdf'; // Ruta al archivo PDF

        $email = 'facundocastano@unbcollections.com.ar'; // Dirección de correo electrónico del destinatario
        $subject = 'Asunto del Correo';
        $data = ['key' => 'value']; // Datos para pasar a la vista del correo si es necesario

        Mail::to($email)
            ->send(new CorreoEjemplo($subject, $data))
            ->attach($pdfPath);

        $this->info('Correo enviado correctamente con el archivo adjunto.');
    }
}
