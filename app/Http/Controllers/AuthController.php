<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserCredential;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use App\Models\LeadsArgentina;
use App\Models\AccionesArgentina;
use App\Models\Usuarios;
use App\Models\LeadsChile;
use App\Models\Agenda;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\Models\Roles;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ReporteDiario;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;

class AuthController extends Controller
{
    public function index()
    {
        try {
            $fechaActual = Carbon::today();
            $reporte = ReporteDiario::where('fecha', $fechaActual)
                ->where('enviado', '1')
                ->whereTime('hora', '>', '16:39') // Filtrar por hora mayor a 17:00
                ->firstOrFail();

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
                            $cantidad = ReporteDiario::whereIn('estado', [6])->count();
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
                            $reportesEstado8 = ReporteDiario::where('estado', 6)->get();
                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }

                            $cantidad = ReporteDiario::whereIn('estado', [3])->count();

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
                            $reportesEstado8 = ReporteDiario::where('estado', 3)->get();
                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }
                            $cantidad = ReporteDiario::whereIn('estado', [11])->count();

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

                            $reportesEstado8 = ReporteDiario::where('estado', 11)->get();
                            foreach ($reportesEstado8 as $reporte) {
                                if ($reporte['descripcion'] != "") {
                                    $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                                }
                            }

                            //---------------COTIZACIONES
                            $cantidad = ReporteDiario::whereIn('estado', [13])->count();

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
                            $reportesEstado8 = ReporteDiario::where('estado', 13)->get();
                            foreach ($reportesEstado8 as $reporte) {
                                $body .= "<span style='margin-bottom:1%'>" . $reporte['descripcion'] . "</span><br><br>";
                            }

                            $cantidad = ReporteDiario::whereIn('estado', [7])->count();

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

                            $reportesEstado8 = ReporteDiario::where('estado', 7)->get();
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
        // Comprobamos si el usuario ya está logado
        if (Auth::check()) {

            // Si está logado le mostramos la vista de logados
            return view('Usuarios');
        }

        // Si no está logado le mostramos la vista con el formulario de login
        return view('login');
    }

    /**
     * Función que se encarga de recibir los datos del formulario de login, comprobar que el usuario existe y
     * en caso correcto logar al usuario
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = UserCredential::where('email', $credentials['email'])
            ->where('activo', 1)
            ->first();

        if (!$user) {
            // No se encontró ningún usuario activo con el correo electrónico proporcionado
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; font-size: 25px;">
            No se encontró ningún usuario activo con ese correo electrónico.</div>';
            return view('login');
        } else {
            session(['email2' => $request->email . ""]);
            $user = UserCredential::where('email', $request->email)->first();

            $password = $user->password;
            $passwordLength = strlen($password);
            if ($passwordLength == 8) {
                return view('loginPIngreso')->with('email', $request->email);
            }
            Session::put('success', true);
            if (Hash::check($request->password, $user->password)) {
                $user = Usuarios::where('email', Session::get('email2'))->first();
                $role = Roles::where('id', $user['rol'])->first();

                $usuario = $user->usuario;
                $ids = $user->id;
                $request->session()->put('usuario', $usuario);
                $request->session()->put('ids', $ids);

                session(['rols' => $role['id'] . ""]);
                Session::put('success', true);
                // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Session::put('success', true);
                // return view('welcome', compact('usuario'))->with('email', $request->email);
                // }
                $request->session()->regenerate();

                return view('welcome')->with('email', $request->email);
            } else {
                echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; font-size: 25px;">
                Usuario o Contraseña incorrecta.</div>';
                return view("login");
            }
            // Si el usuario no existe devolvemos al usuario al formulario de login con un mensaje de error
        }
    }
    public function logout(Request $request, Redirector $redirect)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
