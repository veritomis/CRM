<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use App\Models\LeadsChile;
use App\Models\AccionesChile;
use App\Models\LeadsArgentina;
use App\Models\Usuarios;

use App\Models\Agenda;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionSolicitada;
use App\Models\ReporteDiario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;
use Carbon\Carbon;
use App\Models\Historial;

class LeadsChileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $leads_chile = LeadsChile::where('cotizacion', "0")->get();

        $leads_chile = LeadsChile::where('cotizacion', "0")
            ->where('tipificacion', '!=', 3)->get();

        if ($request->has('tipificacion')) {
            if ($request->input('tipificacion') == 0) {
                $leads_chile = LeadsChile::where('cotizacion', "0")
                    ->where('tipificacion', '!=', 3)->get();
            } else {
                $tipificacionSeleccionada = $request->input('tipificacion');
                $leads_chile = LeadsChile::where('cotizacion', "0")
                    ->where('tipificacion', $tipificacionSeleccionada)
                    ->get();
            }
        }


        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');

            foreach ($leads_chile as $lead) {
                $lead->num_acciones = $lead->accioneschile()->count();
            }

            // Resto de la lógica del controlador
            return view('leads_chile.index', [
                'leads_chile' => LeadsChile::orderBy('created_at', 'desc')->get(),             
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }
    
 

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('leads_chile.create')->with($variable);
        } else {
            return view('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $campaign_name = $request->input('campaign_name');
        $form_id = $request->input('form_id');
        $form_name = $request->input('form_name');
        $is_organic = $request->input('is_organic');
        $platform = $request->input('platform');
        $cuentanos_mas_sobre_el_proyecto = $request->input('cuentanos_sobre_el_proyecto');
        $full_name = $request->input('full_name');
        $work_phone_number = $request->input('phone_number');
        $work_email = $request->input('email');
        $nombre_de_la_empresa = $request->input('company_name');
        $job_title = $request->input('job_title');

        $input = $request->all();        
        //Fina
        if ($campaign_name == "") {
            Session::flash('Campaña_error', 'El campo de Campaña es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($form_id == "") {
            Session::flash('ID_error', 'El campo de ID Formulario es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($form_name == "") {
            Session::flash('Formulario_error', 'El campo de Formulario es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($is_organic == "") {
            Session::flash('Organizacion_error', 'El campo de Organización es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($platform == "") {
            Session::flash('Plataforma_error', 'El campo de Plataforma es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($cuentanos_mas_sobre_el_proyecto == "") {
            Session::flash('proyecto_error', 'El campo de Informacion del proyecto es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($full_name == "") {
            Session::flash('Nombre_error', 'El campo de Nombre es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($work_phone_number == "") {
            Session::flash('Telefono_error', 'El campo de Telefono es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($work_email == "") {
            Session::flash('email_error', 'El campo de Email es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($nombre_de_la_empresa == "") {
            Session::flash('Empresa_error', 'El campo de Empresa es obligatorio.');
            return redirect()->back()->withInput();
        }
        if ($job_title == "") {
            Session::flash('Puesto_error', 'El campo de Puesto es obligatorio.');
            return redirect()->back()->withInput();
        }
        $input = $request->all();
        $leads_chile = LeadsChile::create($input);
        $ultimoIdIngresado = $leads_chile->id;

        $Historial = new Historial();
        $Historial->persona_id = $ultimoIdIngresado;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se agrego un presupuesto (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $reporte = new ReporteDiario();
        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $ultimoIdIngresado; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n Leads Chile: Se agrego un nuevo Leads con el id-> {$ultimoIdIngresado}"; // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->estado = 5; // modificacioens 

        $reporte->pais = '2';
        $reporte->save();

        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se agrego correctamente.');

            return redirect('leads_chile')->with('leads_chile', $leads_chile)->with('variable', $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $leads_chile = leadsChile::findOrFail($id);

        // Obtener los apoderados relacionados con la persona jurídica
        $acciones_chile = accionesChile::where('lead', $id)->get();

        $usuarios = Usuarios::pluck('usuario', 'id');

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('leads_chile.show', [
                'leads_chile' => $leads_chile,
                'acciones_chile' => $acciones_chile,
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
    public function edit(string $id): View
    {
        $leads_chile = leadsChile::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            // Resto de la lógica del controlador
            return view('leads_chile.edit', [
                'leads_chile' => $leads_chile,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $anterior  = leadsChile::where('id', $id)->first();

        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se edito un presupuesto (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();
        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsChile::where('id', $id)->first();
        $empres = $empresa['campaign_name'];

        $cambios = [];
        $cambios[] = "-El usuario $usuario, ha realizado EDICIONES a la empresa $empres con el ID $id
        en la seccion Leads Chile ";

        if ($anterior->campaign_name !== $request->input('campaign_name')) {
            $cambios[] = "\n nombre -> Valor anterior: " . $anterior->campaign_name . " - Valor actual: " . $request->input('campaign_name');
        }
        if ($anterior->form_id !== $request->input('form_id')) {
            $cambios[] = "\n ID Formulario -> Valor anterior: " . $anterior->form_id . " - Valor actual: " . $request->input('form_id');
        }
        if ($anterior->form_name !== $request->input('form_name')) {
            $cambios[] = "\n Nombre Formulario -> Valor anterior: " . $anterior->form_name . " - Valor actual: " . $request->input('form_name');
        }
        if ($anterior->is_organic !== $request->input('is_organic')) {
            $cambios[] = "\n Se modificó la Organización -> Valor anterior: " . $anterior->is_organic . " - Valor actual: " . $request->input('is_organic');
        }
        if ($anterior->platform !== $request->input('platform')) {
            $cambios[] = "\n Se modificó la Plataforma -> Valor anterior: " . $anterior->platform . " - Valor actual: " . $request->input('platform');
        }
        if ($anterior->cuentanos_sobre_el_proyecto !== $request->input('cuentanos_sobre_el_proyecto')) {
            $cambios[] = "\n Se modificó la Info del proyecto -> Valor anterior: " . $anterior->cuentanos_sobre_el_proyecto . " - Valor actual: " . $request->input('cuentanos_sobre_el_proyecto');
        }
        if ($anterior->full_name !== $request->input('full_name')) {
            $cambios[] = "\n Nombre -> Valor anterior: " . $anterior->full_name . " - Valor actual: " . $request->input('full_name');
        }
        if ($anterior->phone_number !== $request->input('phone_number')) {
            $cambios[] = "\n Teléfono -> Valor anterior: " . $anterior->phone_number . " - Valor actual: " . $request->input('phone_number');
        }
        if ($anterior->email !== $request->input('email')) {
            $cambios[] = "\n Email -> Valor anterior: " . $anterior->email . " - Valor actual: " . $request->input('email');
        }
        if ($anterior->company_name !== $request->input('company_name')) {
            $cambios[] = "\n Se modificó la Empresa -> Valor anterior: " . $anterior->company_name . " - Valor actual: " . $request->input('company_name');
        }
        if ($anterior->job_title !== $request->input('job_title')) {
            $cambios[] = "\n Puesto -> Valor anterior: " . $anterior->job_title . " - Valor actual: " . $request->input('job_title');
        }
        //REPORTES DIARIOS
        if (!empty($cambios)) {
            $reporte = new ReporteDiario();
            $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
            $reporte->idcaso = $request->input('id'); // Asigna el ID del caso correspondiente
            $reporte->descripcion = implode("\n", $cambios); // Descripción de los cambios separados por nueva línea
            $reporte->fecha = today(); // Asigna la fecha y hora actual
            $reporte->estado = 9; // modificaciones
            $reporte->pais = '2';
            $reporte->save();
        }
        //FIN

        $leads_chile = leadsChile::find($id);

        $input = $request->all();

        $leads_chile->update($input);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se actualizó correctamente.');

            return redirect('leads_chile')->with('flash_message', 'leads_chile Updated!', $variable);
        } else {
            return view('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se descarto un lead (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $reporte = new ReporteDiario();
        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $empresa = LeadsChile::where('id', $id)->first();
        $empres = $empresa['campaign_name'];

        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $id; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n -El usuario $usuario, DESCARTADO EL LEADS de la empresa $empres con el ID $id
        en la seccion Leads Chile"; // Descripción de los cambios separados por nueva línea

        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->estado = 3; //el 3 es Descartado

        $reporte->pais = '2';
        $reporte->save();

        session()->flash('message', 'El registro se elimino correctamente.');

        $seguimiento = leadsChile::find($id);
        $seguimiento->update(['tipificacion' => "3"]);
        //leadsChile::destroy($id);
        return redirect('leads_chile')->with('flash_message', 'leads_chile deleted!');
    }
    public function solicitarCotizacion($id)
    {
        // Buscar el lead por el ID
        $lead = leadsChile::find($id);
        $nombreC = $lead->company_name;
        $Historial = new Historial();
        $Historial->persona_id = $id;
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se solicito un presupuesto (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();

        $user = Usuarios::where('id', session('ids'))->first();
        $usuario = $user['name'] . " " . $user['apellido'];

        $reporte = new ReporteDiario();

        $empresa = LeadsChile::where('id', $id)->first();
        $empres = $empresa['campaign_name'];

        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $id; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n -El usuario $usuario, ha SOLICITADO COTIZACION a la empresa $empres con el ID $id
        en la seccion Leads Chile"; // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual

        $reporte->estado = 13; //el 13 es cotizaciones
        $reporte->pais = '2';
        $reporte->save();

        $usuario = Usuarios::all();

        if ($lead) {
            foreach ($usuario as $user) {
                $cotizador = $user->cotizador;
                if ($cotizador == 1) {
                    // Actualizar la columna "cotizacion" a 1
                    $lead->update(['cotizacion' => 1]);
                    $lead->update(['tipificacion' => 6]);
                    $email = $user->email;
                    $nombreU = $user->usuario;
                    // Envío del correo
                    //Mail::to($email)->send(new CotizacionSolicitada($nombreC, $nombreU));
                }
            }
            // Redireccionar o hacer algo más después de enviar el correo y actualizar la columna.
            // Por ejemplo, puedes redireccionar al listado de leads o a una página de confirmación.
            return redirect('leads_chile')->with('flash_message', 'Cotizacion solicitada!');
        } else {
        }
    }
}
