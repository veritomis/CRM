<?php

namespace App\Console\Commands;

use App\Models\ReporteDiario;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;
use App\Models\Usuarios;
use App\Models\LeadsArgentina;
use App\Models\LeadsChile;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * Execute the console command.
     */
    protected $signature = 'emails:send';
    protected $description = 'Enviar reporte';

    public function handle()
    {
        $dompdf = new Dompdf();
        // Contenido del cuerpo del documento
        $body = '';
        $users = ReporteDiario::get();
        foreach ($users as $user) {
            $remindedDate = Carbon::parse($user->fecha); // Parse the reminded_date

            if ($remindedDate->isToday()) {
                $reportes = ReporteDiario::whereDate('fecha', Carbon::today())
                    ->orderBy('descripcion', 'asc')
                    ->get();

                foreach ($reportes as $reporte) {
                    $user2 = Usuarios::where('id', $reporte->iduser)->first();

                    if ($reporte->idcaso == 2) {
                        $empresa = LeadsChile::where('id', $reporte->iduser)->first();
                        $empres = $empresa['campaign_name'];
                    } else {
                        $empresa = LeadsArgentina::where('id', $reporte->iduser)->first();
                        $empres = $empresa['campaign_name'];
                    }

                    $usuario = $user2['name'] . " " . $user2['apellido'];
                    // Agregar los detalles del reporte al cuerpo del documento
                    $body .= "<br>ID Usuario: $usuario\n";
                    $body .= "<br>ID Caso: $reporte->idcaso De la empresa: $empres\n";
                    $body .= "<br>Descripción: $reporte->descripcion\n";
                    $body .= "<br>Fecha: $reporte->fecha\n";
                    $body .= "<br>\n <br>"; // Separador entre reportes
                }
            }
            $html = $body;
            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);
            $dompdf->render();
            $pdfContent = $dompdf->output();

            $filename = 'reporte_Diario.pdf';

            // Guardar el archivo PDF en una ubicación temporal o permanente
            // Aquí, se guarda en la carpeta "storage/app/public" con el nombre generado
            // Puedes ajustar la ubicación y nombre del archivo según tus necesidades
            file_put_contents(storage_path('app/public/' . $filename), $pdfContent);
            $pdfPath = storage_path('app/public/' . $filename);

            $destinatario = 'facundocastanio@destrezalegal.com.ar'; // Cambia esto al destinatario real

            Mail::to($destinatario)->send(new EnviarReporte($destinatario, $pdfPath));
        }
    }
}
