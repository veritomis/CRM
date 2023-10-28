<?php

namespace App\Http\Controllers;

use App\Models\FormData;
use Dompdf\Dompdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailWithGeneratedPDF;
use App\Mail\EnviarReporte;

use App\Models\GastoVariable;

use App\Models\LeadsArgentina;
use App\Models\AccionesArgentina;
use App\Models\Usuarios;
use App\Models\LeadsChile;

use App\Models\ReporteDiario;
use App\Models\Historial;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Options;

class PDFController extends Controller
{
    public function verPDF($id)
    {
        //$proyecto = FormData::find($id);
        $id = FormData::where('id', $id)->orderByDesc('id')->value('idconsulta');
        $id = FormData::where('idconsulta', $id)->orderByDesc('id')->value('id');

        $usuario['8'] = $id;
        $proyecto = FormData::where('id', $id)->first();
        $proyecto2 = FormData::where('id', $id)->get();

        if (!$proyecto) {
            return redirect()->back()->with('error', 'El proyecto no existe.');
        }

        // Aquí define la lógica para seleccionar la imagen adecuada en función de la opción
        $signo = "US$";
        $imgC = "https://unbcollections.com.ar/wp-content/uploads/2023/01/cropped-UNB.png";
        // Establecer la conexión con la base de datos

        $id = $id;
        $id = substr($id, 0, 6) . '-' . substr($id, 6);

        $imgC = "https://unbcollections.com.ar/wp-content/uploads/2023/01/cropped-UNB.png";


        $datosE = LeadsArgentina::where('id', $proyecto->idconsulta)->get();
        $datosE2 = LeadsArgentina::where('id', $proyecto->idconsulta)->first();

        // Crea una instancia de Dompdf
        define("DOMPDF_ENABLE_PHP", true);

        // Configuración de dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isJavascriptEnabled', true);

        // Create an instance of Dompdf
        $dompdf = new Dompdf($options);

        // Contenido del encabezado
        $header = '<!DOCTYPE html>
        <html>
        
        <head>
            <style>
                @page {
                    margin: 0.5cm 1cm;
                }
                .footer {
                    text-align: center;
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    background-color: #f2f2f2; /* Cambia el color de fondo según tus preferencias */
                    border-top: 1px solid #ddd; /* Puedes agregar un borde superior si lo deseas */
                    padding: 10px 0;
                }
                body {
                    margin-top: 2cm;
                    margin-left: 0.1cm;
                    margin-right: 0.1cm;
                    margin-bottom: 1.1cm;
                }
                
                .header {
                    text-align: center;
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 0.5cm;
                }
        
                .header img {
                    max-width: 180px;
                    display: inline-block;
                    vertical-align: middle;
                }
        
                .header h3 {
                    margin: 0;
                    display: inline-block;
                    vertical-align: middle;
                    margin-left: 10px;
                }
        
                .logo {
                    flex: 1;
                }
        
                .logo img {
                    width: 150px;
                    float: left;
                }
        
                .titulo {
                    flex: 1;
                    text-align: right;
                }
            </style>
        </head>
        
        <body>
        <div class="header">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex: 1;">
                        <img src="' . $imgC . '" alt="Logo de la Empresa" width="150px" style="float: left;">
                    </div>
                    <div style="flex: 1;">
                        <h2 style="margin: 0; text-align: right;">COTIZACIÓN N° ' . $id . '</h2>
                    </div>
                </div>
            
        
        
            <br>
            <br>
            <div style="border-top: 3px solid red; width: 100%;"></div>
            <br>
            <br>
            </div>
 ';

        // Contenido del cuerpo del documento
        $body = '
        <p>Don. <strong>' . $datosE2->full_name . '</strong></p>
        
        <p>A continuación enviamos cotización por los servicios de desarrollo de software a medida para su
        empresa</p>
        <strong style="color:red;">Proyecto:</strong><b>' . $datosE2->nombre_de_la_empresa . '</b>
        <strong><p style="color: red; text-decoration: underline;">Antecedentes:</p></strong
        <p>' . $datosE2->cuentanos_mas_sobre_el_proyecto . '</p>
        <p>De un análisis del requerimiento se determina que el software a integrar debe poseer
        las siguientes funcionalidades como base:
        </p>
        ';

        foreach ($proyecto2 as $proyectos) {

            $a = 0;
            $body .= '
            <br> <!-- Agregar un salto de línea 
            <h3 style="text-align: center;">' . utf8_decode($proyectos->nombre_proyecto) . '</h3>-->
            <table style="width:100%; border-collapse: collapse;">
            <tr>
    <th style="background-color: #3E4095; color: #000000; font-weight: bold; width: 50%;">ABMs / Procesos</th>
    <th style="background-color: #3E4095; color: #000000; font-weight: bold; width: 50%;">Breve descripción</th>
</tr>
';
            $colors = ['#FFB6C1', '#FFD700', '#87CEEB', '#98FB98', '#FFA07A', '#FFDAB9', '#D8BFD8', '#DDA0DD', '#B0E0E6', '#F0E68C'];

            $colorIndex = 0;
            // Obtener los datos de la tabla desde la base de datos
            $datosProyec = FormData::where('nombre_proyecto', $proyectos->nombre_proyecto)->get();
            //dd($datosProyec);
            $moduloAnterior = ''; // Variable para almacenar el nombre del módulo anterior
            if ($datosProyec) {
                //dd($datosProyec);
                foreach ($datosProyec as $datosProyecs) {
                    $a = 0; // Reiniciar el contador $a en cada iteración del bucle externo
                    $cantidadM = $datosProyecs->cantidad_modulos;
                    $cantidadProcesos = $datosProyecs->cantidad_procesos_1;
                    // DD($datosProyecs);

                    while ($a < $cantidadProcesos) {
                        $body .= '<tr>';

                        // Añadir celda para la columna "ABMs / Procesos"
                        switch ($a + 1) {
                            case 1:
                                $abmsText = $datosProyecs->nombre_proceso_1;
                                break;
                            case 2:
                                $abmsText = $datosProyecs->nombre_proceso_2;
                                break;
                            case 3:
                                $abmsText = $datosProyecs->nombre_proceso_3;
                                break;
                            case 4:
                                $abmsText = $datosProyecs->nombre_proceso_4;
                                break;
                            case 5:
                                $abmsText = $datosProyecs->nombre_proceso_5;
                                break;
                            case 6:
                                $abmsText = $datosProyecs->nombre_proceso_6;
                                break;
                            case 7:
                                $abmsText = $datosProyecs->nombre_proceso_7;
                                break;
                            case 8:
                                $abmsText = $datosProyecs->nombre_proceso_8;
                                break;
                            case 9:
                                $abmsText = $datosProyecs->nombre_proceso_9;
                                break;
                            case 10:
                                $abmsText = $datosProyecs->nombre_proceso_10;
                                break;
                            default:
                                $abmsText = ''; // Valor por defecto si es necesario
                                break;
                        }
                        //dd($abmsText);
                        $color = $colors[$colorIndex];
                        $body .= '<td style="background-color: ' . $color . '; color: #000000; width: 50%; text-align: center;">' . utf8_decode($abmsText) . '</td>';
                        $colorIndex += 1;

                        switch ($a + 1) {
                            case 1:
                                $descripcionText = $datosProyecs->descripcion_proceso_1;
                                break;
                            case 2:
                                $descripcionText = $datosProyecs->descripcion_proceso_2;
                                break;
                            case 3:
                                $descripcionText = $datosProyecs->descripcion_proceso_3;
                                break;
                            case 4:
                                $descripcionText = $datosProyecs->descripcion_proceso_4;
                                break;
                            case 5:
                                $descripcionText = $datosProyecs->descripcion_proceso_5;
                                break;
                            case 6:
                                $descripcionText = $datosProyecs->descripcion_proceso_6;
                                break;
                            case 7:
                                $descripcionText = $datosProyecs->descripcion_proceso_7;
                                break;
                            case 8:
                                $descripcionText = $datosProyecs->descripcion_proceso_8;
                                break;
                            case 9:
                                $descripcionText = $datosProyecs->descripcion_proceso_9;
                                break;
                            case 10:
                                $descripcionText = $datosProyecs->descripcion_proceso_10;
                                break;
                            default:
                                $descripcionText = ''; // Valor por defecto si es necesario
                                break;
                        }
                        // Añadir celda para la columna "Descripcion"
                        //$descripcionText = $datosProyecs->descripcion_proceso_ . ($a + 1) . '';


                        $body .= '<td style="color: #000000; width: 106%; text-align: center;">' . utf8_decode($descripcionText) . '</td>';
                        $body .= '</tr>';

                        $a += 1;

                        // Al final del bucle, actualizar el valor de $moduloAnterior
                        $moduloAnterior = $datosProyecs->nombre_modulo;
                    }
                }
            }
            $body .= '</table>';
        }
        $body .= '.
        

        <div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Tiempo de Implementación:</p>
    <span style="font-weight: bold;">
        '. $proyecto->T_implementaciOn .'
    </span>

</div>
<div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Facilidades y modalidades de pago para la implementación:</p>
    <span style="font-weight: bold;">
    '.$proyecto->T_implementaciOn .'
    </span>

</div>';


$body .='
<p>
    <span style="color: red; text-decoration: underline;">Costo del Cloud Hosting y base de datos para el
        proyecto:</span> 0.50 UF mensual, los cuales podrán abonarse en forma mensual, o bien semestral o anual para
    obtener descuentos durante la vigencia del contrato de mantenimiento y soporte.
</p>


<div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Tiempo de desarrollo:
        <span style="font-weight: bold;">
        '.$proyecto->T_implementaciOn .'
        </span>
    </p>
</div>


<div style="page-break-after: always;"></div>

    <p style="color: red; text-align: center;">¿Por qué elegirnos?</p>
    <hr style="color:blue;">
    <p style="color: red;">Fortalezas</p>
    <div style="border: 1px solid black; padding: 10px;">

        <p>Profesionales de la contabilidad y de la administración de empresas que realizan los análisis funcionales de
            las automatizaciones empresariales, para asegurar el cumplimiento de los estándares contables y fiscales
            requeridos para el proyecto.</p>

        <hr style="border: 1px solid black;">
        <p>Rápida adaptabilidad al cambio y agilidad en la toma de decisiones corporativas.</p>
        <hr style="border: 1px solid black;">
        <p>Acceso a un pool de talento en la región que es de mayor amplitud que en otras regiones, pudiendo ofrecer
            costos competitivos en comparación a otras empresas del rubro.</p>
    </div>

    <style>
        .red-text {
            color: red;
        }

        .centered-text {
            text-align: center;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>

    <p class="red-text centered-text"><strong>Nuestros clientes</strong></p>
    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SJLyAsociados.jpg?fit=886%2C279&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/UNB-Corporate.png?fit=267%2C157&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto; margin-left: 20px;">
    </div>

    <p>En estos proyectos nuestro socio necesitaba desarrollar un software para el seguimiento de sus operaciones en los
        ámbitos legales, contables, financieros y de la gestión de las personas. A su vez, tenía la necesidad de
        desarrollar un sistema de pagos en línea para automatizar y clasificar los pagos de sus clientes dentro de estas
        plataformas propietarias.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/LogoDLFT-180x180-1.png?fit=180%2C180&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;margin: 0 auto; text-align: center; display: block;">
    </div>


    <p>En este proyecto, nuestro socio contaba con el desafío de la transformación digital de sus operaciones. Uno de
        sus principales objetivos era poder lograr el análisis de casos prejudiciales mediante la utilización de las
        nuevas tecnologías, así como la automatización en la creación de escritos y clasificación de documentación legal
        o la implementación del software como servicio, entre otros desafíos.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SanMartinAsis.jpg?fit=300%2C76&ssl=1"
            alt="Logo proveedor" style="width: 250px; height: auto;margin: 0 auto; text-align: center; display: block;">
    </div>


    <p>En este proyecto ayudamos a nuestro socio a implementar la aplicación de la inteligencia artificial para el
        asesoramiento en línea de clientes, así como la presencia en internet de la marca.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SolucionesSuDeuda.jpeg?fit=521%2C313&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;">
    </div>


    <p>En este proyecto, nuestro socio contaba con el desafío de transformación digital de sus operaciones mediante la
        implementación de diversas soluciones como ser la automatización en la creación de escritos prejudiciales o la
        comunicación automatizada por medios electrónicos con las partes reclamadas, así como la implementación de
        software como servicio, entre otros desafíos.</p>

    <p class="red-text centered-text"><strong>Alguno de Nuestros Proveedores</strong></p>
    <div class="image-wrapper" style="text-align: center;">
        <img src="http://unbcollections.com.ar/cupones/Imagen2.jpg" alt="Logo proveedor"
            style="width: 550px; height: auto;">
        <p>Exequiel David Cardozo</p>
    </div>

    <p>Esperando ser parte de sus proyectos.</p>
    <p>Saludamos cordialmente,</p>
    <div
        style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; margin: 0;">
        <img src="http://unbcollections.com.ar/cupones/Imagen1.jpg" alt="Logo proveedor"
            style="width: 150px; height: auto;">
        <p>Exequiel David Cardozo</p>
        <p>UNB COLLECTIONS S.A.</p>
    </div> 

    <footer style="text-align: center; position: fixed; bottom: 2.5%; width: 100%; margin-bottom: -1cm;">
    <img src="http://181.118.69.61:8015/footer.png" alt="">
</footer>
    </body>

    </html>';


        // Combinar el contenido del encabezado y el cuerpo del documento
        $html = $header . $body;

        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

        // Devolver el PDF como respuesta para visualización en una nueva ventana/pestaña
        $response = new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);

        return $response;
    }

    public function mailReportes()
    {
        $reportes = ReporteDiario::whereDate('fecha', Carbon::today())->get();
        $dompdf = new Dompdf();
        // Contenido del cuerpo del documento
        $body = '';

        foreach ($reportes as $reporte) {
            // Agregar los detalles del reporte al cuerpo del documento
            $user = Usuarios::where('id', $reporte->iduser)->first();


            if ($reporte->idcaso == 2) {
                $empresa = LeadsChile::where('id', $reporte->iduser)->first();
                $empres = $empresa['campaign_name'];
            } else {
                $empresa = LeadsArgentina::where('id', $reporte->iduser)->first();
                $empres = $empresa['campaign_name'];
            }

            // Divide la descripción en segmentos usando "Se modificó" como separador
            $segmentos = explode("Se modificó", $reporte->descripcion);

            // Reconstruye los segmentos con saltos de línea entre ellos
            $descripcionFormateada = implode("\nSe modificó", $segmentos);
            $usuario = $user['name'] . " " . $user['apellido'];
            // Agregar los detalles del reporte al cuerpo del documento
            $body .= "<br>ID Usuario: $usuario\n";
            $body .= "<br>ID Caso: $reporte->idcaso De la empresa: $empres\n";
            $body .= "<br>Descripción: $reporte->descripcion\n";
            $body .= "<br>Fecha: $reporte->fecha\n";
            $body .= "<br>\n <br>"; // Separador entre reportes
        }

        $html = $body;
        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $filename = 'reporte_Diario.pdf';

        // Guardar el archivo PDF en una ubicación temporal o permanente
        // Aquí, se guarda en la carpeta "storage/app/public" con el nombre generado
        // Puedes ajustar la ubicación y nombre del archivo según tus necesidades
        file_put_contents(storage_path('app/public/' . $filename), $pdfContent);
        $pdfPath = storage_path('app/public/' . $filename);

        $destinatario = 'facundocastano@unbcollections.com.ar'; // Cambia esto al destinatario real

        Mail::to($destinatario)->send(new EnviarReporte($destinatario, $pdfPath));
        return redirect()->back()->with('mensaje', 'Correo enviado con éxito.');
    }
    public function enviarCotizacionMail(Request $request, $id)
    {
        //$proyecto = FormData::find($id);
        $id = FormData::where('id', $id)->orderByDesc('id')->value('idconsulta');
        $usuario['8'] = $id;
        $id = FormData::where('idconsulta', $id)->orderByDesc('id')->value('id');

        $proyecto  = FormData::where('id', $id)
            ->where('idconsulta', '!=', 15)->first();
        $proyecto2 = FormData::where('id', $id)
            ->where('idconsulta', '!=', 15)->get();

        
        if (!$proyecto) {
            return redirect()->back()->with('error', 'El proyecto no existe.');
        }

        // Aquí define la lógica para seleccionar la imagen adecuada en función de la opción
        $signo = "US$";
        $imgC = "https://unbcollections.com.ar/wp-content/uploads/2023/01/cropped-UNB.png";
        // Establecer la conexión con la base de datos

        $id = $id;
        $id = substr($id, 0, 6) . '-' . substr($id, 6);

        $imgC = "https://unbcollections.com.ar/wp-content/uploads/2023/01/cropped-UNB.png";


        $datosE = LeadsArgentina::where('id', $proyecto->idconsulta)->get();
        $datosE2 = LeadsArgentina::where('id', $proyecto->idconsulta)->first();

        // Crea una instancia de Dompdf
        define("DOMPDF_ENABLE_PHP", true);

        // Configuración de dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isJavascriptEnabled', true);

        // Create an instance of Dompdf
        $dompdf = new Dompdf($options);

        // Contenido del encabezado
        $header = '<!DOCTYPE html>
        <html>
        
        <head>
            <style>
                @page {
                    margin: 0.5cm 1cm;
                }
                .footer {
                    text-align: center;
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    background-color: #f2f2f2; /* Cambia el color de fondo según tus preferencias */
                    border-top: 1px solid #ddd; /* Puedes agregar un borde superior si lo deseas */
                    padding: 10px 0;
                }
                body {
                    margin-top: 2cm;
                    margin-left: 0.1cm;
                    margin-right: 0.1cm;
                    margin-bottom: 1.1cm;
                }
                
                .header {
                    text-align: center;
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 0.5cm;
                }
        
                .header img {
                    max-width: 180px;
                    display: inline-block;
                    vertical-align: middle;
                }
        
                .header h3 {
                    margin: 0;
                    display: inline-block;
                    vertical-align: middle;
                    margin-left: 10px;
                }
        
                .logo {
                    flex: 1;
                }
        
                .logo img {
                    width: 150px;
                    float: left;
                }
        
                .titulo {
                    flex: 1;
                    text-align: right;
                }
            </style>
        </head>
        
        <body>
        <div class="header">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex: 1;">
                        <img src="' . $imgC . '" alt="Logo de la Empresa" width="150px" style="float: left;">
                    </div>
                    <div style="flex: 1;">
                        <h2 style="margin: 0; text-align: right;">COTIZACIÓN N° ' . $id . '</h2>
                    </div>
                </div>
            
        
        
            <br>
            <br>
            <div style="border-top: 3px solid red; width: 100%;"></div>
            <br>
            <br>
            </div>
 ';

        // Contenido del cuerpo del documento
        $body = '
        <p>Don. <strong>' . $datosE2->full_name . '</strong></p>
        
        <p>A continuación enviamos cotización por los servicios de desarrollo de software a medida para su
        empresa</p>
        <strong style="color:red;">Proyecto:</strong><b>' . $datosE2->nombre_de_la_empresa . '</b>
        <strong><p style="color: red; text-decoration: underline;">Antecedentes:</p></strong
        <p>' . $datosE2->cuentanos_mas_sobre_el_proyecto . '</p>
        <p>De un análisis del requerimiento se determina que el software a integrar debe poseer
        las siguientes funcionalidades como base:
        </p>
        ';

        foreach ($proyecto2 as $proyectos) {

            $a = 0;
            $body .= '
            <br> <!-- Agregar un salto de línea 
            <h3 style="text-align: center;">' . utf8_decode($proyectos->nombre_proyecto) . '</h3>-->
            <table style="width:100%; border-collapse: collapse;">
            <tr>
    <th style="background-color: #3E4095; color: #000000; font-weight: bold; width: 50%;">ABMs / Procesos</th>
    <th style="background-color: #3E4095; color: #000000; font-weight: bold; width: 50%;">Breve descripción</th>
</tr>
';
            $colors = ['#FFB6C1', '#FFD700', '#87CEEB', '#98FB98', '#FFA07A', '#FFDAB9', '#D8BFD8', '#DDA0DD', '#B0E0E6', '#F0E68C'];

            $colorIndex = 0;
            // Obtener los datos de la tabla desde la base de datos
            $datosProyec = FormData::where('nombre_proyecto', $proyectos->nombre_proyecto)->get();
            //dd($datosProyec);
            $moduloAnterior = ''; // Variable para almacenar el nombre del módulo anterior
            if ($datosProyec) {
                //dd($datosProyec);
                foreach ($datosProyec as $datosProyecs) {
                    $a = 0; // Reiniciar el contador $a en cada iteración del bucle externo
                    $cantidadM = $datosProyecs->cantidad_modulos;
                    $cantidadProcesos = $datosProyecs->cantidad_procesos_1;
                    // DD($datosProyecs);

                    while ($a < $cantidadProcesos) {
                        $body .= '<tr>';

                        // Añadir celda para la columna "ABMs / Procesos"
                        switch ($a + 1) {
                            case 1:
                                $abmsText = $datosProyecs->nombre_proceso_1;
                                break;
                            case 2:
                                $abmsText = $datosProyecs->nombre_proceso_2;
                                break;
                            case 3:
                                $abmsText = $datosProyecs->nombre_proceso_3;
                                break;
                            case 4:
                                $abmsText = $datosProyecs->nombre_proceso_4;
                                break;
                            case 5:
                                $abmsText = $datosProyecs->nombre_proceso_5;
                                break;
                            case 6:
                                $abmsText = $datosProyecs->nombre_proceso_6;
                                break;
                            case 7:
                                $abmsText = $datosProyecs->nombre_proceso_7;
                                break;
                            case 8:
                                $abmsText = $datosProyecs->nombre_proceso_8;
                                break;
                            case 9:
                                $abmsText = $datosProyecs->nombre_proceso_9;
                                break;
                            case 10:
                                $abmsText = $datosProyecs->nombre_proceso_10;
                                break;
                            default:
                                $abmsText = ''; // Valor por defecto si es necesario
                                break;
                        }
                        //dd($abmsText);
                        $color = $colors[$colorIndex];
                        $body .= '<td style="background-color: ' . $color . '; color: #000000; width: 50%; text-align: center;">' . utf8_decode($abmsText) . '</td>';
                        $colorIndex += 1;

                        switch ($a + 1) {
                            case 1:
                                $descripcionText = $datosProyecs->descripcion_proceso_1;
                                break;
                            case 2:
                                $descripcionText = $datosProyecs->descripcion_proceso_2;
                                break;
                            case 3:
                                $descripcionText = $datosProyecs->descripcion_proceso_3;
                                break;
                            case 4:
                                $descripcionText = $datosProyecs->descripcion_proceso_4;
                                break;
                            case 5:
                                $descripcionText = $datosProyecs->descripcion_proceso_5;
                                break;
                            case 6:
                                $descripcionText = $datosProyecs->descripcion_proceso_6;
                                break;
                            case 7:
                                $descripcionText = $datosProyecs->descripcion_proceso_7;
                                break;
                            case 8:
                                $descripcionText = $datosProyecs->descripcion_proceso_8;
                                break;
                            case 9:
                                $descripcionText = $datosProyecs->descripcion_proceso_9;
                                break;
                            case 10:
                                $descripcionText = $datosProyecs->descripcion_proceso_10;
                                break;
                            default:
                                $descripcionText = ''; // Valor por defecto si es necesario
                                break;
                        }
                        // Añadir celda para la columna "Descripcion"
                        //$descripcionText = $datosProyecs->descripcion_proceso_ . ($a + 1) . '';


                        $body .= '<td style="color: #000000; width: 106%; text-align: center;">' . utf8_decode($descripcionText) . '</td>';
                        $body .= '</tr>';

                        $a += 1;

                        // Al final del bucle, actualizar el valor de $moduloAnterior
                        $moduloAnterior = $datosProyecs->nombre_modulo;
                    }
                }
            }
            $body .= '</table>';
        }
        $body .= '.
        

        <div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Tiempo de Implementación:</p>
    <span style="font-weight: bold;">
        '. $proyecto->T_implementaciOn .'
    </span>

</div>
<div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Facilidades y modalidades de pago para la implementación:</p>
    <span style="font-weight: bold;">
    '.$proyecto->T_implementaciOn .'
    </span>

</div>';


$body .='
<p>
    <span style="color: red; text-decoration: underline;">Costo del Cloud Hosting y base de datos para el
        proyecto:</span> 0.50 UF mensual, los cuales podrán abonarse en forma mensual, o bien semestral o anual para
    obtener descuentos durante la vigencia del contrato de mantenimiento y soporte.
</p>


<div style="display: flex; align-items: center;">
    <p style="color: red; text-decoration: underline; margin-right: 5px;">
        Tiempo de desarrollo:
        <span style="font-weight: bold;">
        '.$proyecto->T_implementaciOn .'
        </span>
    </p>
</div>


<div style="page-break-after: always;"></div>

    <p style="color: red; text-align: center;">¿Por qué elegirnos?</p>
    <hr style="color:blue;">
    <p style="color: red;">Fortalezas</p>
    <div style="border: 1px solid black; padding: 10px;">

        <p>Profesionales de la contabilidad y de la administración de empresas que realizan los análisis funcionales de
            las automatizaciones empresariales, para asegurar el cumplimiento de los estándares contables y fiscales
            requeridos para el proyecto.</p>

        <hr style="border: 1px solid black;">
        <p>Rápida adaptabilidad al cambio y agilidad en la toma de decisiones corporativas.</p>
        <hr style="border: 1px solid black;">
        <p>Acceso a un pool de talento en la región que es de mayor amplitud que en otras regiones, pudiendo ofrecer
            costos competitivos en comparación a otras empresas del rubro.</p>
    </div>

    <style>
        .red-text {
            color: red;
        }

        .centered-text {
            text-align: center;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>

    <p class="red-text centered-text"><strong>Nuestros clientes</strong></p>
    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SJLyAsociados.jpg?fit=886%2C279&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/UNB-Corporate.png?fit=267%2C157&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto; margin-left: 20px;">
    </div>

    <p>En estos proyectos nuestro socio necesitaba desarrollar un software para el seguimiento de sus operaciones en los
        ámbitos legales, contables, financieros y de la gestión de las personas. A su vez, tenía la necesidad de
        desarrollar un sistema de pagos en línea para automatizar y clasificar los pagos de sus clientes dentro de estas
        plataformas propietarias.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/LogoDLFT-180x180-1.png?fit=180%2C180&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;margin: 0 auto; text-align: center; display: block;">
    </div>


    <p>En este proyecto, nuestro socio contaba con el desafío de la transformación digital de sus operaciones. Uno de
        sus principales objetivos era poder lograr el análisis de casos prejudiciales mediante la utilización de las
        nuevas tecnologías, así como la automatización en la creación de escritos y clasificación de documentación legal
        o la implementación del software como servicio, entre otros desafíos.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SanMartinAsis.jpg?fit=300%2C76&ssl=1"
            alt="Logo proveedor" style="width: 250px; height: auto;margin: 0 auto; text-align: center; display: block;">
    </div>


    <p>En este proyecto ayudamos a nuestro socio a implementar la aplicación de la inteligencia artificial para el
        asesoramiento en línea de clientes, así como la presencia en internet de la marca.</p>

    <div class="image-wrapper" style="text-align: center;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SolucionesSuDeuda.jpeg?fit=521%2C313&ssl=1"
            alt="Logo proveedor" style="width: 150px; height: auto;">
    </div>


    <p>En este proyecto, nuestro socio contaba con el desafío de transformación digital de sus operaciones mediante la
        implementación de diversas soluciones como ser la automatización en la creación de escritos prejudiciales o la
        comunicación automatizada por medios electrónicos con las partes reclamadas, así como la implementación de
        software como servicio, entre otros desafíos.</p>

    <p class="red-text centered-text"><strong>Alguno de Nuestros Proveedores</strong></p>
    <div class="image-wrapper" style="text-align: center;">
        <img src="http://unbcollections.com.ar/cupones/Imagen2.jpg" alt="Logo proveedor"
            style="width: 550px; height: auto;">
        <p>Exequiel David Cardozo</p>
    </div>

    <p>Esperando ser parte de sus proyectos.</p>
    <p>Saludamos cordialmente,</p>
    <div
        style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; margin: 0;">
        <img src="http://unbcollections.com.ar/cupones/Imagen1.jpg" alt="Logo proveedor"
            style="width: 150px; height: auto;">
        <p>Exequiel David Cardozo</p>
        <p>UNB COLLECTIONS S.A.</p>
    </div> 

    <footer style="text-align: center; position: fixed; bottom: 2.5%; width: 100%; margin-bottom: -1cm;">
    <img src="http://181.118.69.61:8015/footer.png" alt="">
</footer>
    </body>

    </html>';


        // Combinar el contenido del encabezado y el cuerpo del documento
        $html = $header . $body;

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $filename = 'Cotizacion.pdf';

        // Guardar el archivo PDF en una ubicación temporal o permanente
        // Aquí, se guarda en la carpeta "storage/app/public" con el nombre generado
        // Puedes ajustar la ubicación y nombre del archivo según tus necesidades
        file_put_contents(storage_path('app/public/' . $filename), $pdfContent);
        $pdfPath = storage_path('app/public/' . $filename);

        $destinatario = $datosE2->work_email; //'facundocastano@unbcollections.com.ar'; // Cambia esto al destinatario real $datosProyec->work_email; //

        Mail::to($destinatario)->send(new EmailWithGeneratedPDF($destinatario, $pdfPath));

        $Historial = new Historial();
        $Historial->persona_id = $usuario['8'];
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se envio una cotizacion (Argentina)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();
        $idd=$usuario['8'];
        $seguimiento = LeadsArgentina::find($idd);
        $seguimiento->update(['tipificacion' => "17"]);

        $reporte = new ReporteDiario();
        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $usuario['8']; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n Leads Argentina: Se envio una cotizacion. id-> {$idd} "; // Descripción de los cambios separados por nueva línea
        $reporte->pais = '1';
        $reporte->fecha = today(); // Asigna la fecha y hora actual


        $reporte->save();
        session()->flash('message', 'Correo enviado con éxito.');

        return redirect()->back()->with('mensaje', 'Correo enviado con éxito.');
        return redirect('http://127.0.0.1:8000/argentina_cotiza/' . $proyecto->idconsulta . '/ver')->with('mensaje', 'Formulario actualizado exitosamente.');
    }
}