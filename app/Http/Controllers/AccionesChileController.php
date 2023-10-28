<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\AccionesChile;

use App\Models\ReporteDiario;

use Carbon\Carbon;
use App\Models\Historial;
use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use App\Models\LeadsChile;
use Illuminate\View\View;

class AccionesChileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($LeadsChile)
    {
        $acciones = AccionesChile::all();
        $acciones = AccionesChile::where('lead', $LeadsChile)->get();
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return redirect('leads_chile.show', compact('lead'))->with('acciones', $acciones, $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($LeadsChile): view
    {
        $variable = session('email');

        if (session('success') == 1) {
            // Resto de la lógica del controlador
            return view('acciones_chile.create', compact('LeadsChile'))->with('variable', $variable);
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
        $Historial->actividad_realizada = "Se agrego un seguimiendo (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $input = $request->all();
        $valorAccion = $request->input('ids');
        $seguimiento = LeadsChile::find($valorAccion);
        $seguimiento->update(['tipificacion' => "2"]);
        
        $accioness = $request->input('accion');
        $comen = $request->input('comentario');
        $fecha = $request->input('fecha');
        $idsC = $request->input('ids');

        $agregado = "-$comen, tipo de evento: $accioness en la fecha $fecha";
 
        if ($request->input('fecha')) {

            $Agendas = new Agenda();
            $Agendas->Nombre = $request->input('accion');
            $Agendas->Comentario = $request->input('comentario');
            $Agendas->fecha = $request->input('fecha');
            $Agendas->idcaso = $request->input('ids');
            $agregado = "-$Agendas->Comentario, tipo de evento: $Agendas->Nombre en la fecha $Agendas->fecha";

            $Agendas->save();
            
        } else {
        }
        //REPORTES DIARIOS
        $ReporteDiario = new ReporteDiario();
        $ReporteDiario->iduser = $request->input('usuario');
        $ReporteDiario->idcaso = $request->input('ids');
        $ReporteDiario->descripcion = $agregado;
        $ReporteDiario->fecha = Carbon::now()->format('Y-m-d');
        $ReporteDiario->estado = 11; // Seguimiento 

        $ReporteDiario->pais = 2;

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

        // Crear la nueva acción
        $acciones = AccionesChile::create($input);

        // Obtener la orden de trabajo correspondiente a la acción creada
        $ordenTrabajo = LeadsChile::find($acciones->lead);

        // Actualizar el campo updated_at de la orden de trabajo
        $ordenTrabajo->touch();


        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se creo correctamente.');

            return redirect('leads_chile')->with('acciones', $acciones)->with('variable', $variable);
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
        $acciones = AccionesChile::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('acciones_chile.show', [
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
        $acciones = AccionesChile::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('acciones_chile.edit')->with('acciones', $acciones, $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsChile::where('id', $id)->first();
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

        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = 1;
        $Historial->actividad_realizada = "Se edito un seguimiendo (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $acciones = AccionesChile::find($id);
        $seguimiento = LeadsChile::find($id);
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
            $LeadsChile = $acciones->lead;
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se Actualizo correctamente.');
            
            return redirect('leads_chile/' . $LeadsChile)->with('flash_message', '¡acciones actualizado!', $variable);
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
}
