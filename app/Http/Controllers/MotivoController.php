<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte; // Asegúrate de usar el modelo correcto
use App\Models\FormData;

use App\Models\LeadsArgentina;
use App\Models\AccionesArgentina;
use App\Models\Usuarios;
use App\Models\LeadsChile;

use Carbon\Carbon;
use App\Models\Historial;
use App\Models\ReporteDiario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionSolicitada;

class MotivoController extends Controller
{
    public function guardarMotivo(Request $request)
    {
        $itemId = $request->input('itemId');
        $reason = $request->input('reason');

        // Aquí puedes guardar el motivo en la base de datos, por ejemplo:
        $Historial = new Historial();
        $Historial->persona_id = $itemId;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se descarto un lead (Argentina)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $reporte = new ReporteDiario();
        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsArgentina::where('id', $itemId)->first();
        $empres = $empresa['campaign_name'];

        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $itemId; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n -El usuario $usuario, RECHAZADO LA COTIZACION de la empresa $empres con el ID $itemId .
        Motivo: $reason .
        en la seccion Cotizacion Argentina"; // Descripción de los cambios separados por nueva línea

        //$reporte->descripcion = implode("\n Argentina: Se descarto un lead. id-> {$itemId}"); // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->estado = 7; //el 7 es Descartado
        $reporte->pais = '1';
        $reporte->save();

        $seguimiento = LeadsArgentina::find($itemId);
        $seguimiento->update(['tipificacion' => "7"]);
        //leadsArgentina::destroy($itemId);
        return response()->json(['message' => 'Motivo guardado exitosamente.']);
    }
}
