<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport_cl; // Necesitarás crear este archivo de importación

class ExcelImportController_cl extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
            'tipificacion' => 'nullable|integer' // Hacer que el campo sea opcional
        ]);

        $file = $request->file('excel_file');
        try {
        Excel::import(new LeadsImport_cl, $file);
       // return redirect('leads_chile')->with('success', 'Datos importados exitosamente.');
       $extension = $file->getClientOriginalExtension();

    if ($extension != 'xls' && $extension != 'xlsx') {
        // El archivo no es un Excel, muestra un mensaje de error
        return back()->withErrors(['error' => 'Por favor, carga un archivo Excel válido (xls o xlsx).']);
    }

       session()->flash('message', 'El excel se cargo correctamente.'); //traido de borrar registro
       return back()->with('flash_message', 'El excel se cargo correctamente!');
       //return redirect()->back()->with('success', 'Excel importado con éxito');
    } catch (\Exception $e) {
        session()->flash('message', 'El excel no se cargo correctamente, verifique que todos los campos estén completos'); //traido de borrar registro
        return back()->with('flash_message', 'El excel no se cargo correctamente , verifique que todos los campos estén completos!');
        //return redirect()->back()->withErrors(['error' => 'No se pudo adjuntar el archivo. Verifica que todos los campos estén completos.']);     
    }
    
}
}

 



