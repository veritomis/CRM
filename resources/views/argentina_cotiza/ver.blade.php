<?php
use App\Models\usuarios;
use App\Models\FormData;

use App\Models\roles;
?>
@extends('leads_argentina.layout')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>
    <!-- Asegúrate de incluir SweetAlert2 y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <nav class="navbar bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Proyectos de Cotizacion Argentina</h2>
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
                            <h5>Leads</h5>
                            <a href="leads_chile" class="nav-link" style="margin-right: 10px;">Leads Chile</a>
                            <a href="leads_argentina" class="nav-link" style="margin-right: 10px;">Leads Argentina</a>

                            <h5>Cotizacion</h5>
                            <a href="chile_cotiza" class="nav-link" style="margin-right: 10px;">Cotiza Chile</a>
                            <a href="argentina_cotiza" class="nav-link" style="margin-right: 10px;">Cotiza Argentina</a>
                            <h5>Otras opciones</h5>
                            <a href="{{ route('cac.agenda') }}" class="nav-link" style="margin-right: 10px;">Agenda</a>



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


    <div class="mx-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">


                        </div>
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="custom-table table" style="text-align: center;">
                                <thead style="background-color: #007BFF;">
                                    <tr>
                                        <thead style="background-color: #007BFF;">
                                            <tr>
                                                <th>N#</th>
                                                <th>Id</th>
                                                <th>Condiciones</th>
                                                <th>Tiempo implementacion</th>
                                                <th>Tiempo Testing</th>
                                                <th>Costo Total</th>
                                                <th>Nombre Proyecto</th>
                                                <th>Descripcion Proyecto</th>
                                                <th>Cantidad Modulos</th>

                                            </tr>
                                        </thead>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Ver = 0;
                                        // Ordenar la colección de leads en la vista
                                        $sortedLeads = $argentina_cotiza->sortBy('updated_at')->sortBy(function ($lead) {
                                            // Primero, ordenar por si tiene o no acciones
                                        
                                            $numAcciones = $lead->num_acciones;
                                            // Luego, ordenar por cotizacion (ascendente)
                                            $cotizacion = $lead->cotizacion;
                                            if ($lead->num_acciones == 0 && $lead->cotizacion == 0) {
                                                return 1;
                                            } elseif ($lead->num_acciones > 0 && $lead->cotizacion == 0) {
                                                return 2;
                                            } elseif ($lead->cotizacion == 1) {
                                                return 3;
                                            }
                                        });
                                    @endphp
                                    @foreach ($sortedLeads as $item)
                                        @php
                                            
                                            $datosE2 = FormData::where('id', $item->id)->first();
                                            
                                            if ($datosE2->tipificacion == 15) {
                                                $Ver = 1;
                                                $valorID = $item->idconsulta;
                                                continue;
                                            }
                                            // Establecer la clase CSS para el color de fondo según las condiciones
                                            $backgroundClass = '';
                                            if ($item->cotizacion == 0 && $item->num_acciones > 0) {
                                                $backgroundClass = 'bg-warning'; // Amarillo
                                            } elseif ($item->cotizacion == 1) {
                                                $backgroundClass = 'bg-success'; // Verde
                                            }
                                        @endphp
                                        <tr class="{{ $backgroundClass }}">

                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->idconsulta }}</td>
                                            <td>{{ $datosE2->condiciones }}</td>
                                            <td>{{ $datosE2->T_implementaciOn }}</td>
                                            <td>{{ $datosE2->Testing }}</td>
                                            <td>{{ $datosE2->Costo_Total }}</td>
                                            <td>{{ $datosE2->nombre_proyecto }}</td>
                                            <td>{{ $datosE2->descripcion_proyecto }}</td>
                                            <td>{{ $datosE2->cantidad_modulos }}</td>

                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <?php
                            if ($Ver == 1) {
                                # code...
                           ?>
                            <!---------------------------------------->
                            <h2>Proyectos anteriores</h2>
                            <table class="custom-table table" style="text-align: center;">
                                <thead style="background-color: #007BFF;">
                                    <tr>
                                        <thead style="background-color: #007BFF;">
                                            <tr>
                                                <th>N#</th>
                                                <th>Id</th>
                                                <th>Condiciones</th>
                                                <th>Tiempo implementacion</th>
                                                <th>Tiempo Testing</th>
                                                <th>Costo Total</th>
                                                <th>Nombre Proyecto</th>
                                                <th>Descripcion Proyecto</th>
                                                <th>Cantidad Modulos</th>

                                            </tr>
                                        </thead>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Ordenar la colección de leads en la vista
                                        
                                        $datosE2Collection = FormData::where('idconsulta', $valorID)
                                            ->where('tipificacion', 15)
                                            ->get();
                                    @endphp
                                    @foreach ($datosE2Collection as $datosE2)
                                        <tr class="{{ $backgroundClass }}">

                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->idconsulta }}</td>
                                            <td>{{ $datosE2->condiciones }}</td>
                                            <td>{{ $datosE2->T_implementaciOn }}</td>
                                            <td>{{ $datosE2->Testing }}</td>
                                            <td>{{ $datosE2->Costo_Total }}</td>
                                            <td>{{ $datosE2->nombre_proyecto }}</td>
                                            <td>{{ $datosE2->descripcion_proyecto }}</td>
                                            <td>{{ $datosE2->cantidad_modulos }}</td>

                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <?php
                        }
                           ?>
                            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
