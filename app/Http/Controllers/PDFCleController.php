<?php

namespace App\Http\Controllers;

use App\Models\FormDataCle;
use Dompdf\Dompdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailWithGeneratedPDF;
use App\Models\LeadsArgentina;
use App\Models\LeadsChile;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\ReporteDiario;
use App\Models\Historial;

use Carbon\Carbon;

class PDFCleController extends Controller
{
    public function verPDF($id)
    {

        $id = FormDataCle::where('id', $id)->orderByDesc('id')->value('idconsulta');
        $id = FormDataCle::where('idconsulta', $id)->orderByDesc('id')->value('id');

        $usuario['8'] = $id;
        $proyecto  = FormDataCle::where('id', $id)
            ->where('idconsulta', '!=', 15)->first();
        $proyecto2 = FormDataCle::where('id', $id)
            ->where('idconsulta', '!=', 15)->get();

        // $proyecto  = FormDataCle::where('idconsulta', $id)
        // ->where('idconsulta', '!=', 15)->first();
        // $proyecto2 = FormDataCle::where('idconsulta', $id)
        // ->where('idconsulta', '!=', 15)->get();

        if (!$proyecto) {
            return redirect()->back()->with('error', 'El proyecto no existe.');
        }

        // Aquí define la lógica para seleccionar la imagen adecuada en función de la opción
        $signo = "US$";
        $imgC = "http://unbcollections.com.ar/cupones/unbc.jpeg";
        // Establecer la conexión con la base de datos

        $id = $id;
        $id = substr($id, 0, 6) . '-' . substr($id, 6);

        $imgC = "http://unbcollections.com.ar/cupones/unbc.jpeg";


        $datosE = LeadsChile::where('id', $proyecto->idconsulta)->get();
        $datosE2 = LeadsChile::where('id', $proyecto->idconsulta)->first();

        // Crea una instancia de Dompdf
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('isHtml5ParserEnabled', false);
        $dompdf = new Dompdf($options);
        // Contenido del encabezado
        $header = '<style>
        .page-break {
            page-break-before: always;
        }
    </style>
        <div style="display: flex; justify-content: space-between; align-items: center;">
    <div style="text-align: right;">
        <img src="' . $imgC . '" alt="Logo de la Empresa" width="150px" style="margin-right: 20px;">
    </div>
    <div style="text-align: right;">
        <h2 style="margin: 0;">COTIZACIÓN N° ' . $id . '</h2>
    </div>
</div>';


        // Contenido del cuerpo del documento
        $body = '
<p>Estimado Sr. ' . $datosE2->full_name . '</p>
<p>' . $datosE2->nombre_de_la_empresa . '</p>
<p style="color: red; text-decoration: underline;">Descripción del Proyecto:</p>
<p>' . $datosE2->cuentanos_mas_sobre_el_proyecto . '</p>
<p>En base al relevamiento del proyecto y el análisis del mismo se proponen implementar y desarrollar los siguientes módulos y funcionalidades, a saber:</p>
';

        foreach ($proyecto2 as $proyectos) {

            $a = 0;
            $body .= '
  <br> <!-- Agregar un salto de línea -->
  <h3 style="text-align: center;">' . utf8_decode($proyectos->nombre_proyecto) . '</h3>
  <table style="width:100%; border-collapse: collapse;">
  <tr>
    <th style="background-color: #ADD8E6; color: #000000; width: 40%;">Modulo</th>
    <th style="background-color: #B0C4DE; color: #000000; width: 50%;">ABMs / Procesos</th>
    <th style="background-color: #B0C4DE; color: #000000; width: 106%;">Descripcion</th>
  </tr>';

            // Obtener los datos de la tabla desde la base de datos
            $datosProyec = FormDataCle::where('nombre_proyecto', $proyectos->nombre_proyecto)->get();
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

                        // Verificar si es la primera fila del módulo actual
                        if ($a === 0 && $datosProyecs->nombre_modulo !== $moduloAnterior) {
                            $moduloText = $datosProyecs->nombre_modulo;
                            $body .= '<td style="background-color: #8FBC8F; color: #000000; width: 40%; text-align: center;">' . utf8_decode($moduloText) . '</td>';
                        } else {
                            $body .= '<td style="background-color: #8FBC8F; color: #000000; width: 40%;"></td>';
                        }

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
                        $body .= '<td style="background-color: #B0C4DE; color: #000000; width: 50%; text-align: center;">' . utf8_decode($abmsText) . '</td>';

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
                        $body .= '<td style="background-color: #B0C4DE; color: #000000; width: 106%; text-align: center;">' . utf8_decode($descripcionText) . '</td>';

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
        <p style="color: red; margin-right: 5px;">Tiempo de Implementación:' . $proyecto->T_implementaciOn . '</p>
    </div>
    <p style="color: red;">Costo total del proyecto' . $proyecto->Costo_Total . '
    <p><strong>(*) Cotización dólar vendedor del Banco Nación de la Argentina al momento del efectivo pago.</strong></p>
    <div style="display: flex; align-items: center;">
        <p style="color: red; margin-right: 5px;">Condiciones de Pago:
        ' . $proyecto->condiciones . '</p>
    </div>
    <div style="display: flex; align-items: center;">
        <p style="color: red; margin-right: 5px;">Validez de la oferta:</p>
        <p>- A definir</p>
    </div>
    

<div class="page-break">

<p style="color: red; text-align: center;">¿Por qué elegirnos?</p>
<hr style="color:blue;">
<p style="color: red;">Fortalezas</p><div style="border: 1px solid black; padding: 10px;">

<p>Profesionales de la contabilidad y de la administración de empresas que realizan los análisis funcionales de las automatizaciones empresariales, para asegurar el cumplimiento de los estándares contables y fiscales requeridos para el proyecto.</p>

<hr style="border: 1px solid black;">
<p>Rápida adaptabilidad al cambio y agilidad en la toma de decisiones corporativas.</p>
<hr style="border: 1px solid black;">
<p>Acceso a un pool de talento en la región que es de mayor amplitud que en otras regiones, pudiendo ofrecer costos competitivos en comparación a otras empresas del rubro.</p>
</div>

<style>
.red-text {
color: red;
}
.centered-text {
text-align: center;
}
</style>

<p class="red-text centered-text"><strong>Nuestros clientes</strong></p>
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SJLyAsociados.jpg?fit=886%2C279&ssl=1" alt="Logo proveedor" style="width: 100px; margin: 0 10px;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/UNB-Corporate.png?fit=267%2C157&ssl=1" alt="Logo proveedor" style="width: 100px; margin: 0 10px;">
    </div>

<p>En estos proyectos nuestro socio necesitaba desarrollar un software para el seguimiento de sus operaciones en los ámbitos legales, contables, financieros y de la gestión de las personas. A su vez, tenía la necesidad de desarrollar un sistema de pagos en línea para automatizar y clasificar los pagos de sus clientes dentro de estas plataformas propietarias.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/LogoDLFT-180x180-1.png?fit=180%2C180&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto, nuestro socio contaba con el desafío de la transformación digital de sus operaciones. Uno de sus principales objetivos era poder lograr el análisis de casos prejudiciales mediante la utilización de las nuevas tecnologías, así como la automatización en la creación de escritos y clasificación de documentación legal o la implementación del software como servicio, entre otros desafíos.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SanMartinAsis.jpg?fit=300%2C76&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto ayudamos a nuestro socio a implementar la aplicación de la inteligencia artificial para el asesoramiento en línea de clientes, así como la presencia en internet de la marca.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SolucionesSuDeuda.jpeg?fit=521%2C313&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto, nuestro socio contaba con el desafío de transformación digital de sus operaciones mediante la implementación de diversas soluciones como ser la automatización en la creación de escritos prejudiciales o la comunicación automatizada por medios electrónicos con las partes reclamadas, así como la implementación de software como servicio, entre otros desafíos.</p>

<p class="red-text centered-text"><strong>Alguno de Nuestros Proveedores</strong></p>
<img src="http://unbcollections.com.ar/cupones/Imagen2.jpg" alt="Logo proveedor" style="width: 50px;"><p>Exequiel David Cardozo</p>

<p>Esperando ser parte de sus proyectos.</p>
<p>Saludamos cordialmente,</p>
<img src="http://unbcollections.com.ar/cupones/Imagen1.jpg" alt="Logo proveedor" style="width: 50px;"><p>Exequiel David Cardozo</p>
<p>UNB COLLECTIONS S.A.</p>';


        // Combinar el contenido del encabezado y el cuerpo del documento
        $html = $header . $body;

        // Cargar el HTML en Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('isHtml5ParserEnabled', false);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

        // Devolver el PDF como respuesta para visualización en una nueva ventana/pestaña
        $response = new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);

        return $response;
    }

    public function enviarCotizacionMail(Request $request, $id)
    {
        $id = FormDataCle::where('id', $id)->orderByDesc('id')->value('idconsulta');
        $usuario['8'] = $id;

        $id = FormDataCle::where('idconsulta', $id)->orderByDesc('id')->value('id');

        $proyecto  = FormDataCle::where('id', $id)
            ->where('idconsulta', '!=', 15)->first();
        $proyecto2 = FormDataCle::where('id', $id)
            ->where('idconsulta', '!=', 15)->get();

        if (!$proyecto) {
            return redirect()->back()->with('error', 'El proyecto no existe.');
        }
        // Aquí define la lógica para seleccionar la imagen adecuada en función de la opción
        $signo = "US$";
        $imgC = "http://unbcollections.com.ar/cupones/unbc.jpeg";
        // Establecer la conexión con la base de datos

        $id = $id;
        $id = substr($id, 0, 6) . '-' . substr($id, 6);

        $imgC = "http://unbcollections.com.ar/cupones/unbc.jpeg";


        $datosE = LeadsChile::where('id', $proyecto->idconsulta)->get();
        $datosE2 = LeadsChile::where('id', $proyecto->idconsulta)->first();

        // Crea una instancia de Dompdf

        // Contenido del encabezado
        $header = '<style>
        .page-break {
            page-break-before: always;
        }
    </style>
        <div style="display: flex; justify-content: space-between; align-items: center;">
    <div style="text-align: right;">
        <img src="' . $imgC . '" alt="Logo de la Empresa" width="150px" style="margin-right: 20px;">
    </div>
    <div style="text-align: right;">
        <h2 style="margin: 0;">COTIZACIÓN N° ' . $id . '</h2>
    </div>
</div>';


        // Contenido del cuerpo del documento
        $body = '
<p>Estimado Sr. ' . $datosE2->full_name . '</p>
<p>' . $datosE2->nombre_de_la_empresa . '</p>
<p style="color: red; text-decoration: underline;">Descripción del Proyecto:</p>
<p>' . $datosE2->cuentanos_mas_sobre_el_proyecto . '</p>
<p>En base al relevamiento del proyecto y el análisis del mismo se proponen implementar y desarrollar los siguientes módulos y funcionalidades, a saber:</p>
';

        foreach ($proyecto2 as $proyectos) {

            $a = 0;
            $body .= '
  <br> <!-- Agregar un salto de línea -->
  <h3 style="text-align: center;">' . utf8_decode($proyectos->nombre_proyecto) . '</h3>
  <table style="width:100%; border-collapse: collapse;">
  <tr>
    <th style="background-color: #ADD8E6; color: #000000; width: 40%;">Modulo</th>
    <th style="background-color: #B0C4DE; color: #000000; width: 50%;">ABMs / Procesos</th>
    <th style="background-color: #B0C4DE; color: #000000; width: 106%;">Descripcion</th>
  </tr>';

            // Obtener los datos de la tabla desde la base de datos
            $datosProyec = FormDataCle::where('nombre_proyecto', $proyectos->nombre_proyecto)->get();
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

                        // Verificar si es la primera fila del módulo actual
                        if ($a === 0 && $datosProyecs->nombre_modulo !== $moduloAnterior) {
                            $moduloText = $datosProyecs->nombre_modulo;
                            $body .= '<td style="background-color: #8FBC8F; color: #000000; width: 40%; text-align: center;">' . utf8_decode($moduloText) . '</td>';
                        } else {
                            $body .= '<td style="background-color: #8FBC8F; color: #000000; width: 40%;"></td>';
                        }

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
                        $body .= '<td style="background-color: #B0C4DE; color: #000000; width: 50%; text-align: center;">' . utf8_decode($abmsText) . '</td>';

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
                        $body .= '<td style="background-color: #B0C4DE; color: #000000; width: 106%; text-align: center;">' . utf8_decode($descripcionText) . '</td>';

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
        <p style="color: red; margin-right: 5px;">Tiempo de Implementación:' . $proyecto->T_implementaciOn . '</p>
    </div>
    <p style="color: red;">Costo total del proyecto' . $proyecto->Costo_Total . '
    <p><strong>(*) Cotización dólar vendedor del Banco Nación de la Argentina al momento del efectivo pago.</strong></p>
    <div style="display: flex; align-items: center;">
        <p style="color: red; margin-right: 5px;">Condiciones de Pago:
        ' . $proyecto->condiciones . '</p>
    </div>
    <div style="display: flex; align-items: center;">
        <p style="color: red; margin-right: 5px;">Validez de la oferta:</p>
        <p>- A definir</p>
    </div>
    

<div class="page-break">

<p style="color: red; text-align: center;">¿Por qué elegirnos?</p>
<hr style="color:blue;">
<p style="color: red;">Fortalezas</p><div style="border: 1px solid black; padding: 10px;">

<p>Profesionales de la contabilidad y de la administración de empresas que realizan los análisis funcionales de las automatizaciones empresariales, para asegurar el cumplimiento de los estándares contables y fiscales requeridos para el proyecto.</p>

<hr style="border: 1px solid black;">
<p>Rápida adaptabilidad al cambio y agilidad en la toma de decisiones corporativas.</p>
<hr style="border: 1px solid black;">
<p>Acceso a un pool de talento en la región que es de mayor amplitud que en otras regiones, pudiendo ofrecer costos competitivos en comparación a otras empresas del rubro.</p>
</div>

<style>
.red-text {
color: red;
}
.centered-text {
text-align: center;
}
</style>

<p class="red-text centered-text"><strong>Nuestros clientes</strong></p>
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SJLyAsociados.jpg?fit=886%2C279&ssl=1" alt="Logo proveedor" style="width: 100px; margin: 0 10px;">
        <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/UNB-Corporate.png?fit=267%2C157&ssl=1" alt="Logo proveedor" style="width: 100px; margin: 0 10px;">
    </div>

<p>En estos proyectos nuestro socio necesitaba desarrollar un software para el seguimiento de sus operaciones en los ámbitos legales, contables, financieros y de la gestión de las personas. A su vez, tenía la necesidad de desarrollar un sistema de pagos en línea para automatizar y clasificar los pagos de sus clientes dentro de estas plataformas propietarias.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/LogoDLFT-180x180-1.png?fit=180%2C180&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto, nuestro socio contaba con el desafío de la transformación digital de sus operaciones. Uno de sus principales objetivos era poder lograr el análisis de casos prejudiciales mediante la utilización de las nuevas tecnologías, así como la automatización en la creación de escritos y clasificación de documentación legal o la implementación del software como servicio, entre otros desafíos.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SanMartinAsis.jpg?fit=300%2C76&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto ayudamos a nuestro socio a implementar la aplicación de la inteligencia artificial para el asesoramiento en línea de clientes, así como la presencia en internet de la marca.</p>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
    <img src="https://i0.wp.com/unbcollections.com.ar/wp-content/uploads/2023/01/SolucionesSuDeuda.jpeg?fit=521%2C313&ssl=1" alt="Logo proveedor" style="width: 100px;">
</div>

<p>En este proyecto, nuestro socio contaba con el desafío de transformación digital de sus operaciones mediante la implementación de diversas soluciones como ser la automatización en la creación de escritos prejudiciales o la comunicación automatizada por medios electrónicos con las partes reclamadas, así como la implementación de software como servicio, entre otros desafíos.</p>

<p class="red-text centered-text"><strong>Alguno de Nuestros Proveedores</strong></p>
<img src="http://unbcollections.com.ar/cupones/Imagen2.jpg" alt="Logo proveedor" style="width: 50px;"><p>Exequiel David Cardozo</p>

<p>Esperando ser parte de sus proyectos.</p>
<p>Saludamos cordialmente,</p>
<img src="http://unbcollections.com.ar/cupones/Imagen1.jpg" alt="Logo proveedor" style="width: 50px;"><p>Exequiel David Cardozo</p>
<p>UNB COLLECTIONS S.A.</p>';


        // Combinar el contenido del encabezado y el cuerpo del documento
        $html = $header . $body;
        $dompdf = new Dompdf();
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

        $destinatario = $datosE2->email;//'facundocastano@unbcollections.com.ar';   // Cambia esto al destinatario real $datosProyec->work_email;

        Mail::to($destinatario)->send(new EmailWithGeneratedPDF($destinatario, $pdfPath));

        $Historial = new Historial();
        $Historial->persona_id = $usuario['8'];
        $Historial->usuario_id = session('ids');
        $Historial->actividad_realizada = "Se envio una cotizacion (Chile)";
        $Historial->fecha_hora = Carbon::now()->format('Y-m-d'); // Establecer la fecha y hora actual

        $Historial->save();
        $idd=$usuario['8'];
        $seguimiento = LeadsChile::find($idd);
        $seguimiento->update(['tipificacion' => "17"]);

        $reporte = new ReporteDiario();
        $reporte->iduser = session('ids'); // Supongo que estás guardando el ID del usuario
        $reporte->idcaso = $usuario['8']; // Asigna el ID del caso correspondiente
        $reporte->descripcion = "\n Leads Chile: Se envio una cotizacion. id-> {$id}"; // Descripción de los cambios separados por nueva línea
        $reporte->fecha = today(); // Asigna la fecha y hora actual
        $reporte->pais = '2';
        $reporte->save();

        session()->flash('message', 'Correo enviado con éxito.');

        return redirect()->back()->with('mensaje', 'Correo enviado con éxito.');
        return redirect('http://127.0.0.1:8000/chile_cotiza/' . $proyecto->idconsulta . '/ver')->with('mensaje', 'Formulario actualizado exitosamente.');
    }
}
