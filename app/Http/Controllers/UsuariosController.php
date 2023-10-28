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
use Illuminate\Support\Facades\Validator;
use App\Models\ReporteDiario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dompdf\Dompdf;
use App\Mail\EnviarReporte;
use Carbon\Carbon;
use App\Models\Historial;

class UsuariosController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware('auth');
    //}
    /**
     * Display a listing of the resource.
     */
    public function index(): View
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
        $usuarios = Usuarios::all();
        $user = Usuarios::where('email', Session::get('email2'))->first();

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            $role = Roles::where('id', Session::get('rols'))
                ->where('usuarios', 1)
                ->first();
            if ($role) {
                $role->roles = $role->roles;
            }

            if (!$role) {
                return view('welcome');
            }
            $role = Roles::where('id', $user['rol'])->first();
            // Resto de la lógica del controlador
            session(['rols' => $role['id'] . ""]);
            $roles = Roles::pluck('nombre', 'id');
            return view('usuarios.index', [
                'usuarios' => $usuarios,
                'roles' => $roles,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }

        return view('usuarios.index')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Roles::pluck('nombre', 'id');

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            // Para una operación exitosa
            
            return view('usuarios.create', compact('roles'))->with($variable);
        } else {
            return view('login');
        }
        return view('usuarios.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Useru = $request->input('usuario');

        $email = $request->input('email');
        $input = $request->all();
        //Usuarios
        $user = Usuarios::where('usuario', $Useru)->first();
        if ($user) {
            // Usuario existe, agregar mensaje de error a la variable de sesión
            Session::flash('usuario_error', 'El Nombre de usuario ya está registrado.');
            return redirect()->back()->withInput();
        }
        //Fina
        if ($email == "") {
            Session::flash('email_error', 'El campo de correo electrónico es obligatorio.');
            return redirect()->back()->withInput();
        }
        
        //Mail
        $user = Usuarios::where('email', $email)->first();

        if ($user) {
            // Email existe, agregar mensaje de error a la variable de sesión
            Session::flash('email_error', 'El email ya está registrado.');
            return redirect()->back()->withInput();
        }
        //Final
        Usuarios::create($input);

        $Response = Mail::to($request['email'])->send(new DemoMail($request['name'], $request['email'], $request['apellido']));
        // Resto de tu lógica después de enviar el correo electrónico
        $usuarios = Usuarios::all();

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se agrego correctamente.');
            $roles = Roles::pluck('nombre', 'id');
            return view('usuarios.index', [
                'usuarios' => $usuarios,
                'roles' => $roles,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
        return view('usuarios.index')->with('usuarios', $usuarios);
          
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $usuarios = Usuarios::find($id);
        $roles = Roles::pluck('nombre', 'id');
        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('usuarios.show', [
                'usuarios' => $usuarios,
                'roles' => $roles,
                'variable' => $variable
            ]);
        } else {
            return view('login');
        }
        return view('usuarios.show')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id): View
    {
        $roles = Roles::pluck('nombre', 'id');
        $usuarios = Usuarios::find($id);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            return view('usuarios.edit', compact('roles'))->with('usuarios', $usuarios, $variable);
        } else {
            return view('login');
        }
        return view('usuarios.edit', compact('roles'))->with('usuarios', $usuarios);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $usuarios = Usuarios::find($id);

        $Useru = $request->input('usuario');

        $email = $request->input('email');
        $input = $request->all();

        //Usuarios
        $user = Usuarios::where('usuario', $Useru)->first();
        if ($user and $user != $usuarios) {
            // Usuario existe, agregar mensaje de error a la variable de sesión
            Session::flash('usuario_error', 'El Nombre de usuario ya está registrado.');
            return redirect()->back()->withInput();
        }
        //Fina
        //Mail
        $user = Usuarios::where('email', $email)->first();

        if ($user and $user != $usuarios) {
            // Email existe, agregar mensaje de error a la variable de sesión
            Session::flash('email_error', 'El email ya está registrado.');
            return redirect()->back()->withInput();
        }

        $input = $request->all();
        $usuarios->update($input);

        $variable = session('email');
        if (session('success') == 1) {
            $variable = session('email');
            // Resto de la lógica del controlador
            session()->flash('message', 'El registro se actualizó correctamente.');
            return redirect('usuarios')->with('flash_message', 'Usuarios Updated!', $variable);
        } else {
            return view('login');
        }
        return redirect('usuarios')->with('flash_message', 'Usuarios Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        session()->flash('message', 'El registro se elimino correctamente.');
        Usuarios::destroy($id);
        return redirect('usuarios')->with('flash_message', 'Usuarios deleted!');
    }         
}
