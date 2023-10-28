<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\FormDataCle; // Asegúrate de usar el modelo correcto para tus proyectos
use Carbon\Carbon;
use App\Models\Historial;
use App\Models\ReporteDiario;
use App\Models\leadsChile;


use App\Http\Controllers\Controller;

class FormDataCleController extends Controller
{
    public function storeForm(Request $request): RedirectResponse
    {

        $estado = 14;

        // Realizar la consulta SQL y verificar si trae algún resultado
        $resultado = FormDataCle::where('idconsulta', $request->input('idconsulta'))->first();

        if ($resultado) {

            FormDataCle::where('idconsulta', $request->input('idconsulta'))->update([
                'tipificacion' => 15,
            ]);
            $estado = 16;
        }

        // Actualizar el valor de "tipificacion"

        $Historial = new Historial();
        $Historial->persona_id = $request->input('idconsulta');
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se agrego un nuevo proyecto (Argentina)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();
        $seguimiento = leadsChile::find($request->input('idconsulta'));
        $seguimiento->update(['tipificacion' => $estado]);
        $hola = true;
        // Obtener todos los datos POST enviados por el formulario
        $datosFormulario = $request->all();

        // Puedes mostrar los datos en la vista, imprimirlos o hacer lo que necesites

        $registro = new FormDataCle();
        $registro->cantidad_modulos = $request->input('cantidad_modulos');

        //dd($datosFormulario);
        for ($i = 0; $i < $registro->cantidad_modulos; $i++) {
            $registro = new FormDataCle();
            $registro->idconsulta = $request->input('idconsulta');
            $registro->nombre_proyecto = $request->input('nombre_proyecto');
            $registro->descripcion_proyecto = $request->input('descripcion_proyecto');
            $registro->cantidad_modulos = $request->input('cantidad_modulos');
            $nombreModulo = $request->input('nombre_modulo_' . $i . '_1');
            $descripcionModulo = $request->input('descripcion_modulo_' . $i . '_1');
            $cantidadProcesos = $request->input('cantidadProcesos0_' . $i);

            $registro->nombre_modulo = $nombreModulo;
            $registro->descripcion_modulo = $descripcionModulo;
            $registro->cantidad_procesos_1 = $cantidadProcesos;

            for ($j = 1; $j <= $cantidadProcesos; $j++) {
                $nombreProceso = $request->input('nombre_proceso_' . $j . '_' . $i);
                $descripcionProceso = $request->input('descripcion_proceso_' . $j . '_' . $i);

                $registro->{'nombre_proceso_' . $j} = $nombreProceso;
                $registro->{'descripcion_proceso_' . $j} = $descripcionProceso;
            }

            $registro->save();

            echo "Datos actualizados exitosamente.";
        }

        //REPORTES DIARIOS
        $ReporteDiario = new ReporteDiario();
        $ReporteDiario->iduser = session('ids');
        $ReporteDiario->idcaso = $request->input('idconsulta');
        $ReporteDiario->descripcion = "Se agrego un nuevo proyecto en Cotizacion Argentina con los siguientes datos: Nombre del proyecto: " . $request->input('nombre_proyecto') . " - La cantidad de modulos: " . $request->input('cantidad_modulos');
        $ReporteDiario->fecha = Carbon::now()->format('Y-m-d');
        $ReporteDiario->pais = 2;

        $ReporteDiario->save();
        //FIN

        //$input = $request->all();
        //FormDataCle::create($input);

        $mensaje = 'Datos Guardados exitosamente.';
        // dd($_POST);
        // Pasar el mensaje a la sesión para mostrarlo en la vista
        return back()->with('mensaje', $mensaje);
    }
}
