<?php
use App\Models\usuarios;
use App\Models\Argentina;
use App\Models\roles;
use App\Models\LeadsChile;
use App\Models\LeadsArgentina;

use App\Models\FormDataCle;
use App\Models\FormData;
?>
@extends('leads_argentina.layout')
@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>
    <!-- Asegúrate de incluir SweetAlert2 y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <nav class="navbar bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Cac Base</h2>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel" style="visibility: visible;width: 200px;">
                <img src="{{ asset('storage/Logo_unbc_color.png') }}" alt="logo"
                    style="max-width: 180px; max-height: 180px; margin-left: 6px;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ session('usuario') }}</h5>
                    <button type="button" class="btn" data-bs-dismiss="offcanvas"> 🡨 </button>
                </div>
                <div class="offcanvas-body">
                    <?php
                    $act = usuarios::where('activo', 1)->first();
                    if (!$act) {
                        echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; font-size: 25px;">
                                                                                                                                                                                Usuario desactivado.
                                                                                                                                                                                <div style="display: flex; justify-content: center; margin-top: 20px;">
                                                                                                                                                                                </div>
                                                                                                                                                                                </div>';
                        exit();
                    } ?>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php
                        $role = roles::where('id', Session::get('rols'))
                            ->where(function ($query) {
                                $query->where('roles', 1)->orWhere('usuarios', 1);
                            })
                            ->first();
                        
                        if ($role) {
                            echo '<h5>Configuración</h5>';
                        }
                        ?>

                        <?php
                        $role = roles::where('id', Session::get('rols'))
                            ->where('usuarios', 1)
                            ->first();
                        if ($role) {
                            $role->roles = $role->roles;
                        } ?>
                        <li class="nav-item">
                            <?php if ($role) {
            ?>
                            <a href="usuarios" class="nav-link" style="margin-right: 10px;">Usuarios</a>
                            <?php
        } ?>
                        </li>
                        <?php $role = roles::where('id', Session::get('rols'))
                            ->where('roles', 1)
                            ->first();
                        if ($role) {
                            $role->roles = $role->roles;
                        } ?>
                        <li class="nav-item">
                            <?php if ($role) {
           ?>
                            <a href="roles" class="nav-link" style="margin-right: 10px;">Roles</a>
                            <?php
        } ?>
                        </li>
                        <?php $role = roles::where('id', Session::get('rols'))
                            ->where('leads', 1)
                            ->first();
                        if ($role) {
                            $role->roles = $role->roles;
                        } ?>
                        <li class="nav-item">
                            <?php if ($role) {
                ?>
                            <a href="leads_chile" class="nav-link" style="margin-right: 10px;">Leads Chile</a>
                            <a href="leads_argentina" class="nav-link" style="margin-right: 10px;">Leads Argentina</a>

                            <a href="chile_cotiza" class="nav-link" style="margin-right: 10px;">Cotiza Chile</a>
                            <a href="argentina_cotiza" class="nav-link" style="margin-right: 10px;">Cotiza Argentina</a>
                            <a href="" class="nav-link" style="margin-right: 10px;">Inbound → Preventa</a>
                            <a href="" class="nav-link" style="margin-right: 10px;">Outbound → Ventas</a>

                            <a href="{{ route('cac.bases') }}" class="nav-link" style="margin-right: 10px;">Cac->Base</a>

                            <?php
            } ?>
                        </li>

                        <li class="nav-item dropdown" style="margin-top: 25%;">
                            <form action="{{ url('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
     
    </br>

    <link rel="stylesheet" href="css/tablas.css" type="text/css">
    <?php
    
    // Tipificaciones a mostrar, aunque no tengan casos
    $tipificaciones = [
        0 => 'Base Virgen - Ventas',
        1071 => 'Base Virgen 2 - Ventas',
        1072 => 'Base Virgen 3 - Ventas',
        9 => 'Contacto Inicial por WhatsApp',
        15 => 'Cotización Aceptada',
        163 => 'Envío de Email',
        164 => 'Derivado para Cotización',
        16 => 'Asesorado por WhatsApp',
        13 => 'Solicito Reunión ( Agendado )',
        16 => 'Cotización Enviada',
    
        20 => 'Cotizacion Descartada',
21 => 'Cotización sin enviar',

        7 => 'Contactado sin respuesta - Ventas',
        1 => 'Ocupado/No Contesta - Ventas',
        1101 => 'Máxima Contactación - Ventas',
        1108 => 'Cliente se contacta - Ventas',
        17 => 'Base Virgen - cobros',
        18 => 'Ocupado/No Contesta - Cobros',
        22 => 'Promesa de Pago de 1ra - Cobros',
        141 => 'Cobros 2da y otras - Cobros',
        1103 => 'Cliente se contacta - Cobros',
        3 => 'Interesado (agendado) - Cobros',
    ];
    
    // Realizar la consulta usando Eloquent para FormDataCle
    $results = LeadsChile::select('tipificacion', \DB::raw('COUNT(*) as rowcount'))
        ->groupBy('tipificacion')
        ->get();
    
    // Crear un arreglo para almacenar las filas con casos
    $filas_con_casos = [];
    
    // Si hay resultados en la tabla, procesarlos
    if ($results->count() > 0) {
        foreach ($results as $result) {
            $tipificacion = $result->tipificacion;
            if (array_key_exists($tipificacion, $tipificaciones)) {
                $result2 = LeadsChile::where('tipificacion', $tipificacion)
                ->get();
    
                $detalle = $tipificaciones[$tipificacion];
    
                $filas_con_casos[] = [
                    'tipificacion' => $tipificacion,
                    'detalle' => $detalle,
                    'rowcount' => $result->rowcount,
                    'no_asignados' => $result2->count(),
                ];
            }
        }
    }
    
    // Realizar la consulta usando Eloquent para FormData
    $results = LeadsArgentina::select('tipificacion', \DB::raw('COUNT(*) as rowcount'))
        ->groupBy('tipificacion')
        ->get();
    
    // Si hay resultados en la tabla, procesarlos
    if ($results->count() > 0) {
        foreach ($results as $result) {
            //echo $result->tipificacion."-";
            $tipificacion = $result->tipificacion;
            if (array_key_exists($tipificacion, $tipificaciones)) {
                $result2 = LeadsArgentina::where('tipificacion', $tipificacion)->get();
    
                $detalle = $tipificaciones[$tipificacion];
    
                $filas_con_casos[] = [
                    'tipificacion' => $tipificacion,
                    'detalle' => $detalle,
                    'rowcount' => $result->rowcount,
                    'no_asignados' => $result2->count(),
                ];
            }
        }
    }
    
    // Mostrar la tabla
    
    ?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <div class="container mt-5">
        <table class="table table-bordered" id="datos">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Detalle</th>
                    <th>Casos Sin Asignar</th>
                    <th>Casos Totales</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $form = 0;
                foreach ($tipificaciones as $tipificacion => $detalle) {
                    $casos_encontrados = false;
                    $rowcount = 0;
                    foreach ($filas_con_casos as $fila) {
                        if ($fila['tipificacion'] == $tipificacion) {
                            $casos_encontrados = true;
                            $rowcount = $fila['rowcount'];
                            $noasignados = $fila['no_asignados'];
                            break;
                        }
                    }
                    echo '<tr>';
                    echo '<td>' . $tipificacion . '</td>';
                    echo '<td>' . $detalle . '</td>';
                    echo '<td>' . ($casos_encontrados ? $noasignados : 0) . '</td>';
                    echo '<td>' . ($casos_encontrados ? $rowcount : 0) . '</td>';
                    echo '<td>';
                    if ($casos_encontrados) {
                        $form = $form + 1;
                        echo "<form name='" . $form . "' id='form" . $form . "' method='post' action='#' >";
                        echo "<button type='submit' class='btn btn-primary btn-sm'>Asignaciones</button>";
                        echo "<input name='fn' type='hidden' value='24'>";
                        echo '<input name="tipificacion" type="hidden" value="' . $tipificacion . '">';
                        echo '</form>';
                    }
                    echo '</td>';
                    echo '<td>';
                    if ($casos_encontrados) {
                        $form = $form + 1;
                        echo "<form name='" . $form . "' id='form" . $form . "' method='post' action='#' >";
                        echo "<button type='submit' class='btn btn-secondary btn-sm'>Ver Casos</button>";
                        echo "<input name='fn' type='hidden' value='27'>";
                        echo "<input name='tipificacion' type='hidden' value='" . $tipificacion . "'>";
                    }
                    echo '</td>';
                    echo '</form>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <?php
    // Mostrar un mensaje si no se encontraron registros con
    
    if (count($filas_con_casos) == 0) {
        echo 'No se encontraron registros.';
    }
    ?>

    <!--Los botones para descargar archivos-->

    <div class="container mt-5">
        <table class="table">
            <tr>
                <td class="text-center">
                    <form action="" method="post" target="_self">
                        <p>
                            <input class="btn btn-primary" type="submit" name="button" value="Descargar Primer Contacto">
                        </p>
                    </form>
                </td>
                <td class="text-center">
                    <form action="" method="post" target="_self">
                        <p>
                            <input class="btn btn-primary" type="submit" name="button" value="Descargar No Contesta">
                        </p>
                    </form>
                </td>
                <td class="text-center">
                    <form action="" method="post" target="_self">
                        <p>
                            <input class="btn btn-primary" type="submit" name="button" value="Descargar Aviso Vence">
                        </p>
                    </form>
                </td>
                <td class="text-center">
                    <form action="" method="post" target="_self">
                        <p>
                            <input class="btn btn-primary" type="submit" name="button"
                                value="Descargar Aviso Casos Vencidos">
                        </p>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--Fin-->




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
