<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Agenda;

use App\Models\LeadsArgentina;
use App\Models\AccionesArgentina;
use App\Models\Usuarios;
use App\Models\LeadsChile;
use App\Models\Roles;
use Illuminate\Http\RedirectResponse;
#use Illuminate\Contracts\View\View;
use Illuminate\View\View;
use App\Mail\resetMail;
use App\Models\ReporteDiario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\Models\Historial;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;

class RolesController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware('auth');
    //}
    public function index(): view
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
        $roles = Roles::all();

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            $role = Roles::where('id', Session::get('rols'))
                ->where('roles', 1)
                ->first();
            if ($role) {
                $role->roles = $role->roles;
            }

            if (!$role) {
                return view('welcome');
            }
            // Resto de la lógica del controlador
            return view('roles.index')->with('roles', $roles, $variable);
        } else {
            return view('login');
        }
        return view('roles.index')->with('roles', $roles);
    }

    public function create(): view
    {
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('roles.create')->with($variable);
        } else {
            return view('login');
        }
        
        return view('roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Roles::create($input);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            session()->flash('message', 'El Rol se agrego correctamente.');

            return redirect('roles')->with('flash_message', 'Rol agregado!', $variable);
        } else {
            return view('login');
        }
        return redirect('roles')->with('flash_message', 'Rol agregado!');
    }

    public function show($id): View
    {
        $roles = Roles::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('roles.show')->with('roles', $roles, $variable);
        } else {
            return view('login');
        }
        return view('roles.show')->with('roles', $roles);
    }

    public function edit($id): View
    {
        $roles = Roles::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador                    
            return view('roles.edit')->with('roles', $roles, $variable);
        } else {
            return view('login');
        }
        return view('roles.edit')->with('roles', $roles);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $roles = Roles::find($id);
        $input = $request->all();
        $roles->update($input);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            session()->flash('message', 'El Rol se actualizó correctamente.');

            return redirect('roles')->with('flash_message', 'Rol actualizado!', $roles, $variable);
        } else {
            return view('login');
        }
        return redirect('roles')->with('flash_message', 'Rol actualizado!');
    }

    public function destroy($id): RedirectResponse
    {
        session()->flash('message', 'El Rol se elimino correctamente.');

        Roles::destroy($id);
        return redirect('roles')->with('flash_message', 'Rol eliminado!');
    }
}
