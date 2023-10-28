<?php

namespace App\Http\Controllers;

use App\Models\FormData;
use Illuminate\Http\Request;

class proyecto_editController extends Controller
{
    public function recotizar($id)
    {
        $proyecto = FormData::find($id);
        return view('proyecto_edit.recotizar', ['proyecto' => $proyecto]);
    }
    public function editProyecto($id)
    {
        $proyecto = FormData::find($id);
        return view('proyecto_edit.editProyecto', ['proyecto' => $proyecto]);
    }
    public function updateProyecto(Request $request, $id)
    {
        $proyecto = FormData::find($id);

        // Actualiza los campos con los datos enviados desde el formulario
        $proyecto->idconsulta = $request->input('idconsulta');
        $proyecto->condiciones = $request->input('condiciones');
        $proyecto->T_implementaciOn = $request->input('T_implementaciOn');
        $proyecto->Testing = $request->input('Testing');
        $proyecto->Costo_Total = $request->input('Costo_Total');
        $proyecto->nombre_proyecto = $request->input('nombre_proyecto');
        $proyecto->descripcion_proyecto = $request->input('descripcion_proyecto');
        $proyecto->cantidad_modulos = $request->input('cantidad_modulos');
        $proyecto->nombre_modulo = $request->input('nombre_modulo');
        $proyecto->descripcion_modulo = $request->input('descripcion_modulo');
        // Actualiza más campos
        $proyecto->cantidad_procesos_1 = $request->input('cantidad_procesos_1');
        $proyecto->nombre_proceso_1 = $request->input('nombre_proceso_1');
        $proyecto->descripcion_proceso_1 = $request->input('descripcion_proceso_1');
        // Actualiza campos de los procesos 2 al 10
        $proyecto->nombre_proceso_2 = $request->input('nombre_proceso_2');
        $proyecto->descripcion_proceso_2 = $request->input('descripcion_proceso_2');
        // Actualiza campos de los procesos 3 al 10

        $proyecto->nombre_proceso_3 = $request->input('nombre_proceso_3');
        $proyecto->descripcion_proceso_3 = $request->input('descripcion_proceso_3');

        $proyecto->nombre_proceso_4 = $request->input('nombre_proceso_4');
        $proyecto->descripcion_proceso_4 = $request->input('descripcion_proceso_4');

        $proyecto->nombre_proceso_5 = $request->input('nombre_proceso_5');
        $proyecto->descripcion_proceso_5 = $request->input('descripcion_proceso_5');

        $proyecto->nombre_proceso_6 = $request->input('nombre_proceso_6');
        $proyecto->descripcion_proceso_6 = $request->input('descripcion_proceso_6');

        $proyecto->nombre_proceso_7 = $request->input('nombre_proceso_7');
        $proyecto->descripcion_proceso_7 = $request->input('descripcion_proceso_7');

        $proyecto->nombre_proceso_8 = $request->input('nombre_proceso_8');
        $proyecto->descripcion_proceso_8 = $request->input('descripcion_proceso_8');

        $proyecto->nombre_proceso_9 = $request->input('nombre_proceso_9');
        $proyecto->descripcion_proceso_9 = $request->input('descripcion_proceso_9');

        $proyecto->nombre_proceso_10 = $request->input('nombre_proceso_10');
        $proyecto->descripcion_proceso_10 = $request->input('descripcion_proceso_10');

        $proyecto->save();

        return redirect('argentina_cotiza')->with('flash_message', 'Proyecto actualizado exitosamente');
    }
}
