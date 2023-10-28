<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\ReporteDiario;
use App\Models\AccionesArgentina;
use Illuminate\Http\RedirectResponse;
use App\Models\LeadsArgentina;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Historial;
use Illuminate\Support\Facades\Storage;

class AccionesArgentinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($LeadsArgentina)
    {
        $acciones = AccionesArgentina::all();
        $acciones = AccionesArgentina::where('lead', $LeadsArgentina)->get();
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return redirect('leads_argentina.show', compact('lead'))->with('acciones', $acciones, $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($LeadsArgentina): view
    {
        $variable = session('email');

        if (session('success') == 1) {
            // Resto de la lógica del controlador
            return view('acciones_argentina.create', compact('LeadsArgentina'))->with('variable', $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Historial = new Historial();
        $Historial->persona_id = $request->input('ids');
        $Historial->usuario_id = $request->input('usuario');
        $Historial->actividad_realizada = "Se agrego un seguimiendo (Argentina)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $input = $request->all();
        $valorAccion = $request->input('ids');
        $seguimiento = LeadsArgentina::find($valorAccion);
        $seguimiento->update(['tipificacion' => "2"]);

        $accioness = $request->input('accion');
        $comen = $request->input('comentario');
        $fecha = $request->input('fecha');
        $idsC = $request->input('ids');

        $agregado = "-$comen, tipo de evento: $accioness en la fecha $fecha";

        $agregarAgenda = $request->has('agregarAgenda');

        if ($request->input('fecha')) {

            $Agendas = new Agenda();
            $Agendas->Nombre = $request->input('accion');
            $Agendas->Comentario = $request->input('comentario');
            $Agendas->fecha = $request->input('fecha');
            $Agendas->idcaso = $request->input('ids');

            $Agendas->save();
        } else {
        }
        //REPORTES DIARIOS
        $ReporteDiario = new ReporteDiario();
        $ReporteDiario->iduser = $request->input('usuario');
        $ReporteDiario->idcaso = $request->input('ids');
        $ReporteDiario->descripcion = $agregado;
        $ReporteDiario->fecha = Carbon::now()->format('Y-m-d');
        $ReporteDiario->estado = 11; // Seguimiento en Leads 

        $ReporteDiario->pais = 1;
        $ReporteDiario->save();
        //FIN

        $Historial = new Historial();
        $Historial->persona_id = $request->input('ids');
        $Historial->usuario_id = 1;
        $Historial->actividad_realizada = "Se agrego un seguimiendo (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $input = $request->all();

        if ($request->hasFile('documento1')) {
            $imagePath = $request->file('documento1')->store('directorio');
        }

        if ($request->hasFile('documento2')) {
            $archivoFotoFacturacion = $request->file('documento2');
            $nombreUnicoFotoFacturacion = $archivoFotoFacturacion->hashName();
            $archivoFotoFacturacion->store("");
            $input['documento2'] = $nombreUnicoFotoFacturacion;
        }

        // Crear la nueva acción
        $acciones = AccionesArgentina::create($input);

        // Obtener la orden de trabajo correspondiente a la acción creada
        $ordenTrabajo = LeadsArgentina::find($acciones->lead);

        // Actualizar el campo updated_at de la orden de trabajo
        $ordenTrabajo->touch();

        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se creo correctamente.');

            return redirect('leads_argentina')->with('acciones', $acciones)->with('variable', $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $usuarios = Usuarios::pluck('usuario', 'id');
        $acciones = AccionesArgentina::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('acciones_argentina.show', [
                'acciones' => $acciones,
                'usuarios' => $usuarios,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acciones = AccionesArgentina::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('acciones_argentina.edit')->with('acciones', $acciones, $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = 1;
        $Historial->actividad_realizada = "Se edito un seguimiendo (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = leadsArgentina::where('id', $id)->first();
        $empres = $empresa['campaign_name'];
        //REPORTES DIARIOS
        $ReporteDiario = new ReporteDiario();
        $ReporteDiario->iduser = $request->input('usuario');
        $ReporteDiario->idcaso = $request->input('ids');
        $ReporteDiario->descripcion = "-El usuario $usuario, ha CARGADO EL SIGUINETE SEGUIMIETO a la empresa $empres con el ID $id";
        $ReporteDiario->fecha = Carbon::now()->format('Y-m-d');
        $ReporteDiario->estado = 9; // modificacioens 

        $ReporteDiario->pais = 2;

        $ReporteDiario->save();
        //FIN

        $acciones = AccionesArgentina::find($id);

        $seguimiento = LeadsArgentina::find($id);

        $input = $request->all();
        if ($request->hasFile('documento1')) {
            $archivoFotoRut = $request->file('documento1');
            $nombreUnicoFotoRut = $archivoFotoRut->hashName();
            $archivoFotoRut->store("");
            $input['documento1'] = $nombreUnicoFotoRut;
        }

        if ($request->hasFile('documento2')) {
            $archivoFotoFacturacion = $request->file('documento2');
            $nombreUnicoFotoFacturacion = $archivoFotoFacturacion->hashName();
            $archivoFotoFacturacion->store("");
            $input['documento2'] = $nombreUnicoFotoFacturacion;
        }
        $acciones->update($input);
        $seguimiento->update(['tipificacion' => "2"]);
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            $LeadsArgentina = $acciones->lead;
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se Actualizo correctamente.');

            return redirect('leads_argentina/' . $LeadsArgentina)->with('flash_message', '¡acciones actualizado!', $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
       
    }
     //agregado 27/10/23 para que se suba el archivo desde acciones argentinas
    /*public function subirArchivo(Request $request)
    {
    $archivo = $request->file('archivo');

    if ($archivo) {
        // Almacena el archivo en la ubicación de almacenamiento configurada
        $archivo->store('uploads', 'uploads'); // 'uploads' es la carpeta de almacenamiento personalizada
        
        return back()->with('success', 'cargado con éxito');
    }

    return redirect()->back()->with('error', 'No se ha seleccionado un archivo');
    }*/

    //subir foto y pdf 27/10/23:
    public function subirArchivo(Request $request)
{
    $request->validate([
        'archivo' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Ajusta los tipos y tamaños de archivo según tus necesidades
    ]);

    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $nombreArchivo = uniqid() . '.' . $archivo->getClientOriginalExtension();
        $archivo->storeAs('uploads', $nombreArchivo, 'public');

        return view('tu_vista', ['nombreArchivo' => $nombreArchivo]);
    }

    return redirect()->back()->with('error', 'Por favor, selecciona una imagen o un archivo PDF.');
}


}
