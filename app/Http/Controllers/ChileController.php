<?php

namespace App\Http\Controllers;

use App\Models\FormDataCle;
use App\Mail\EnviarReporte;
use App\Models\Agenda;
use App\Models\GastoVariable;

use Illuminate\Http\Request;
use App\Models\LeadsArgentina;
use App\Models\LeadsChile;

use App\Models\AccionesChile;
use App\Models\Usuarios;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionSolicitada;
use App\Models\FormData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dompdf\Dompdf;

use App\Models\Historial;
use App\Models\Lead;
use App\Models\ReporteDiario;

class ChileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function acepta(Request $request, $id)
    {
        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se Acepto la Cotizacion";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $proyecto = LeadsChile::where('id', $id)->firstOrFail();
        $proyecto->id = $proyecto->id;

        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsChile::where('id', $id)->first();
        $empres = $empresa['campaign_name'];


        $reporte = new ReporteDiario();
        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $id; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "-El usuario $usuario, ha APROBADO LA COTIZACION N° $proyecto->id de la empresa $empres con el ID $id
        en la seccion Cotizacion Chile"; // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->pais = '2';
        $reporte->estado = 13; //Acepta cotizacion proyecto argentina/chile
        $reporte->save();

        $seguimiento = LeadsChile::find($id);
        $seguimiento->update(['tipificacion' => "13"]);

        return back()->with('flash_message', 'leads_chile deleted!');
    }

    public function editProyecto(string $id): View
    {
        $proyecto = FormDataCle::where('idconsulta', $id)->firstOrFail();
        $proyecto->idconsulta = $proyecto->idconsulta; // Asegura que idconsulta esté presente en el objeto
        return view('chile_cotiza.editProyecto', ['proyecto' => $proyecto]);
    }
    public function updateProyecto(Request $request, $id)
    {
        $GastoV = new GastoVariable();
        $vueltas = $request->input('identificador');
        for ($i = 1; $i <= $vueltas; $i++) {

            $GastoV->nombre = $request->input($i . '_nombre');
            $GastoV->descripcion = $request->input($i . '_descripcion');
            $GastoV->monto = $request->input($i . '_monto');
            $GastoV->proyecto_id = $id;

            $GastoV->save();
        }
        $idconsulta = FormDataCle::find($id)->idconsulta;

        FormDataCle::where('idconsulta', $idconsulta)
            ->where(function ($query) {
                $query->where('tipificacion', '!=', 15)
                    ->orWhereNull('tipificacion'); // Agrega esta condición
            })
            ->update([
                'condiciones' => $request->input('condiciones'),
                'T_implementaciOn' => $request->input('T_implementaciOn'),
                'Testing' => $request->input('Testing'),
                'Costo_Total' => $request->input('Costo_Total'),
                // Actualiza más campos
            ]);

        // Resto de tu código
        $seguimiento = LeadsChile::find($idconsulta);
        $seguimiento->update(['tipificacion' => "14"]);
        $proyecto = FormData::find($id);
        session()->flash('message', 'Se Modifico la cotizacion.');
        // Actualiza los campos con los datos enviados desde el formulario

        return redirect('chile_cotiza?tipificacion=0')->with('flash_message', 'Proyecto actualizado exitosamente');
    }

    public function index(Request $request): View
    {

        try {
            $fechaActual = Carbon::today();
            $reporte = ReporteDiario::where('fecha', $fechaActual)
                ->where('enviado', '1')
                ->whereTime('hora', '>', '16:39') // Filtrar por hora mayor a 17:00
                ->firstOrFail();

            // dd($reporte);
            if ($reporte) {
                $horaAlmacenada = $reporte->hora; // Hora almacenada en la base de datos
                $horaActual = date('H:i');
                if ($horaActual >= $horaAlmacenada) {
                    if ($horaActual >= $horaAlmacenada) {
                        $users = ReporteDiario::get();
?>

                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f5f5f5;
                                margin: 0;
                                padding: 20px;
                            }

                            .section {
                                margin-bottom: 30px;
                                padding: 20px;
                                background-color: #fff;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                            }

                            .section h2 {
                                font-size: 20px;
                                margin-bottom: 10px;
                            }

                            .section p {
                                margin-bottom: 5px;
                            }

                            .section span {
                                display: block;
                                margin-bottom: 5px;
                            }

                            .section a {
                                color: white;
                                text-decoration: none;
                            }
                        </style>

<?php
                        // Contenido del cuerpo del documento
                        $body = '';
                        $vuelta = 1;

                        if ($vuelta == 1) {
                            $vuelta = 2;

                            $reportes = ReporteDiario::whereDate('fecha', Carbon::today())->get();

                            // Agregar los detalles del reporte al cuerpo del documento
                            $user = Usuarios::where('id', $reporte->iduser)->first();

                            // Divide la descripción en segmentos usando "Se modificó" como separador update reportes_diarios set enviado = 1 where id!=0; 
                            $cantidad = ReporteDiario::where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39') // Filtrar por hora mayor a 16:39
                                ->whereIn('estado', [6])
                                ->count();

                            // Reconstruye los segmentos con saltos de línea entre ellos
                            $body .= "<div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #ff0a1b;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>LEADS</div>
                                <br><br>
                                <div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #ff0a1b;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
        <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>LEADS A COTIZAR = $cantidad</span>
    </div><br>";
                            $reportesEstado8 = ReporteDiario::where('estado', 6)
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->get();

                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }

                            $cantidad = ReporteDiario::whereIn('estado', [3])
                                ->where('fecha', $fechaActual) // Agregar la condición de fecha
                                ->where('enviado', '1') // Agregar la condición de enviado igual a 1
                                ->whereTime('hora', '>', '16:39') // Agregar la condición de hora mayor a 16:39
                                ->count();


                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #ff0a1b;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>LEADS DESCARTADOS = $cantidad</span>
                            </div><br>";
                            $reportesEstado8 = ReporteDiario::where('estado', 3)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->get();

                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }
                            $cantidad = ReporteDiario::where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->whereIn('estado', [11])
                                ->count();


                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #ff0a1b;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>LEADS EN SEGUIMIENTO = $cantidad</span>
                            </div><br>";

                            $reportesEstado8 = ReporteDiario::where('estado', 11)
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->get();

                            foreach ($reportesEstado8 as $reporte) {
                                if ($reporte['descripcion'] != "") {
                                    $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                                }
                            }

                            //---------------COTIZACIONES
                            $cantidad = ReporteDiario::whereIn('estado', [13])
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->count();


                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #007bff;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>COTIZACIONES</div>
                                <br><br>
                                <div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #007bff;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>COTIZACIONES APROBADAS = $cantidad</span>
                            </div><br>";
                            $reportesEstado8 = ReporteDiario::where('estado', 13)
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->get();

                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }

                            $cantidad = ReporteDiario::whereIn('estado', [7])
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->count();


                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #007bff;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>COTIZACIONES DESCARTADOS = $cantidad</span>
                            </div><br>";

                            $reportesEstado8 = ReporteDiario::where('estado', 7)
                                ->where('fecha', $fechaActual)
                                ->where('enviado', '1')
                                ->whereTime('hora', '>', '16:39')
                                ->get();

                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br> <br>";
                            }

                            $agendas = Agenda::all();
                            $cantidad = $agendas->count();

                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #007bff;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>AGENDA = $cantidad</span>
                            </div><br>
                            <div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                color: #007bff;;
                                /* Color del texto azul */
                                margin-bottom: 10px;
                                /* Espacio inferior */
                                text-align: center;
                                /* Centrar el texto */
                                text-decoration: underline;'>Se ha agregado a la agenda los siguientes eventos.</div> ";

                            $agendas = Agenda::all();

                            foreach ($agendas as $agenda) {
                                $body .=  "Nombre: $agenda->Nombre, Comentario: $agenda->Comentario, Fecha: $agenda->fecha <br>";
                            }
                            $reportesEstado8 = ReporteDiario::whereIn('estado', [10, 9])->get();
                            $cantidad = $reportesEstado8->count();

                            $body .= "<br><div style='font-family: Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                background-color: #007bff;
                                /* Color de fondo azul */
                                color: white;
                                /* Color del texto blanco */
                                padding: 10px 20px;
                                /* Espaciado interno */
                                border-radius: 5px;
                                /* Bordes redondeados */
                                display: inline-block;
                                /* Mostrar en línea */'>
                                <span style='font-weight: bold;
                                color: white;
                                /* Color del texto azul */
                                text-decoration: underline;'>EDICIONES = $cantidad</span>
                            </div><br>";

                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "$reporte->descripcion";
                            }
                        }

                        $html = $body;

                        $destinatario = 'facundocastanio@destrezalegal.com.ar'; // Cambia esto al destinatario real


                        Mail::to($destinatario)->send(new EnviarReporte($html));
                        $reportes = ReporteDiario::whereDate('fecha', Carbon::today())->get();

                        foreach ($reportes as $reporte) {
                            $reporte->update(['enviado' => 0]);
                        }
                    }
                }
            }
        } catch (ModelNotFoundException $exception) {
        }
        $chile_cotiza = LeadsChile::where('cotizacion', 1)
            ->where('tipificacion', '!=', 7)->get();

        if ($request->has('tipificacion')) {
            if ($request->input('tipificacion') == 0) {
                $chile_cotiza = LeadsChile::where('cotizacion', "1")
                    ->where('tipificacion', '!=', 7)->get();
            } else {
                $tipificacionSeleccionada = $request->input('tipificacion');
                $chile_cotiza = LeadsChile::where('cotizacion', "1")
                    ->where('tipificacion', $tipificacionSeleccionada)
                    ->get();
            }
        }
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');

            foreach ($chile_cotiza as $lead) {
                $lead->num_acciones = $lead->accioneschile()->count();
            }
            // Resto de la lógica del controlador
            return view('chile_cotiza.index', [
                'chile_cotiza' => $chile_cotiza,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ver(string $id)
    {
        $Chile_cotiza2 = FormDataCle::where('idconsulta', $id)->first();

        $chile_cotiza = FormDataCle::select('id', 'idconsulta', 'nombre_proyecto')
            ->where('idconsulta', $id)
            ->orWhere('nombre_proyecto', 'LIKE', '%' . $Chile_cotiza2->nombre_proyecto . '%') // Cambia esto por tu variable $nombreProyecto
            ->distinct()
            ->get();

        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            return view('chile_cotiza.ver', [
                'chile_cotiza' => $chile_cotiza,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }

    public function edit(string $id)
    {

        $chile_cotiza = LeadsChile::findOrFail($id);
        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            return view('chile_cotiza.editar', [
                'chile_cotiza' => $chile_cotiza,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }
    public function recotizar(string $id): View
    {
        $proyecto = FormDataCle::where('idconsulta', $id)->firstOrFail();
        $proyecto->idconsulta = $proyecto->idconsulta; // Asegura que idconsulta esté presente en el objeto
        return view('chile_cotiza.recotizar', ['proyecto' => $proyecto]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Realiza la actualización directamente en la base de datos
        LeadsChile::where('id', $id)->update([
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
        ]);

        //dd($idconsulta);
        $anterior  = LeadsChile::where('id', $id)->first();

        $Historial = new Historial();
        $Historial->persona_id = $request->input('id');
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se edito un seguimiendo (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $cambios = [];
        $cambios[] = "Chile (Cotizacion): ";
        if ($anterior->phone_number !== $request->input('phone_number')) {
            $cambios[] = "\n Teléfono -> Valor anterior: " . $anterior->phone_number . " - Valor actual: " . $request->input('phone_number');
        }
        if ($anterior->email !== $request->input('email')) {
            $cambios[] = "\n Email -> Valor anterior: " . $anterior->email . " - Valor actual: " . $request->input('email');
        }
        //REPORTES DIARIOS
        if (!empty($cambios)) {
            $reporte = new ReporteDiario();
            $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
            $reporte->idcaso = $request->input('id'); // Asigna el ID del caso correspondiente
            $reporte->descripcion = implode("\n", $cambios); // Descripción de los cambios separados por nueva línea
            $reporte->fecha = today(); // Asigna la fecha y hora actual
            $reporte->pais = '2';
            $reporte->estado = 10; //modificaciones cotizacion proyecto argentina/chile
            $reporte->save();
        }
        //FIN
        session()->flash('message', 'El registro se actualizó correctamente.');

        return redirect('chile_cotiza')->with('flash_message', 'chile_cotiza Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se descarto un lead (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();
        //$reason = request('deleteReason');
        $reason = $request->input('deleteReason');

        $reporte = new ReporteDiario();
        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsChile::where('id', $id)->first();
        $empres = $empresa['campaign_name'];

        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $id; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n -El usuario $usuario, DESCARTADO LA COTIZACION de la empresa $empres con el ID $id. 
        Motivo: $reason .
        en la seccion Cotizacion Chile"; // Descripción de los cambios separados por nueva línea

        //$reporte->descripcion = implode("\n Argentina: Se descarto un lead. id-> {$id}"); // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->estado = 7; //el 7 es Descartado
        $reporte->pais = '2';
        $reporte->save();

        $seguimiento = LeadsChile::find($id);
        $seguimiento->update(['tipificacion' => "7"]);
        //dd($id);
        //leadsArgentina::destroy($id);
        session()->flash('message', 'El registro se elimino correctamente.');

        //dd($reason);
        return back()->with('flash_message', 'chile_cotiza deleted!');
    }
}
