<?php
use App\Models\usuarios;
use App\Models\Argentina;
use App\Models\roles;
use App\Models\FormData;
use App\Models\ReporteDiario;
use Illuminate\Pagination\Paginator;

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <nav class="navbar bg-light fixed-top">
        @include('flash::message')
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Cotizacion Argentina</h2>
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
                            <h5>Otras opciones</h5> <a href="{{ route('cac.agenda') }}" class="nav-link"
                                style="margin-right: 10px;">Agenda</a>

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
    <div class="card">
                    <div class="card-body">
                    <div class="row">
                    <div class="col-8">
                    <div class="boton-al-lado">
                    <div class="ancho-input">
                        <form action="{{ request()->url() }}" method="get">
                            <div class="form-group">
                                <label for="tipificacion">Seleccionar Estado:</label>
                                <select name="tipificacion" id="tipificacion" class="form-control">
                                    <option value="0"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '0' ? 'selected' : '' }}>
                                        Todas las tipificaciones</option>
                                    <option value="13"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '13' ? 'selected' : '' }}>
                                        Acepta</option>
                                    <option value="6"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '6' ? 'selected' : '' }}>
                                        Solicita Cotizacion</option>
                                    <option value="14"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '14' ? 'selected' : '' }}>
                                        Tiene análisis</option>
                                    <option value="7"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '7' ? 'selected' : '' }}>
                                        Descartado</option>

                                    <!-- Agrega más opciones de tipificación según tus necesidades -->
                                </select>
                            </div>
                            </div>
                            
                            <div class="col-4">
                            <button style="margin-top: 1%" type="submit" class="btn btn-primary">Filtrar</button></div>
                            
                            </div>
                            </div>
                            
                        </form>
                       
                        </div>
                        </div>
                        <br />
                        <br />
                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="custom-table table" style="text-align: center;">
                                <thead style="background-color: #007BFF;">
                                    <tr>
                                        <th>#</th>
                                        <th>Campaña</th>
                                        <th>N° Caso</th>
                                        <th>Formulario</th>
                                        <th>Organización</th>
                                        <th>Plataforma</th>
                                        <th>Informacion del proyecto</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Empresa</th>
                                        <th>Puesto</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Ordenar la colección de leads en la vista
                                        // Ordenar la colección de leads en la vista
                                        $perPage = 10;
                                        $currentPage = request()->get('page', 1); // Obtiene el número de página actual
                                        
                                        $argentina_cotiza = $argentina_cotiza->sortBy(function ($lead) {
                                            // Primero, ordenar por tipificación
                                            return $lead->tipificacion;
                                        });
                                        
                                        /*$argentina_cotiza = $argentina_cotiza->sortBy(function ($lead) {
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
                                        });*/
                                        
                                        $pagedData = $argentina_cotiza->forPage($currentPage, $perPage);
                                        $leadsPaginator = new \Illuminate\Pagination\LengthAwarePaginator($pagedData, $argentina_cotiza->count(), $perPage, $currentPage);
                                        $leadsPaginator->setPath(request()->url()); // Establece la URL base para la paginación
                                    @endphp
                                    @foreach ($leadsPaginator as $item)
                                        @php
                                            // Establecer la clase CSS para el color de fondo según las condiciones
                                            $color = '';
                                            $azull = 0;
                                            // Establecer la clase CSS para el color de fondo según las condiciones
                                            $backgroundClass = '';
                                            if ($item->cotizacion == 0 && $item->num_acciones > 0) {
                                                $backgroundClass = 'bg-warning'; //##883544 Amarillo
                                            } elseif ($item->tipificacion == 7) {
                                                $color = 'background-color: #ff414d'; // Verde
                                                $backgroundClass = '';
                                            } elseif ($item->cotizacion == 1) {
                                                $color = 'background-color: #e9a036'; // Verde
                                                $backgroundClass = '';
                                            }
                                            if ($item->tipificacion == 16) {
                                                $color = 'background-color: #d3b616'; // Verde
                                                $backgroundClass = '';
                                            }
                                            
                                            if ($item->tipificacion == 7) {
                                                $color = 'background-color: #ff414d'; // Verde
                                                $backgroundClass = '';
                                            }
                                            
                                            if ($item->tipificacion == 14 or $item->tipificacion == 17) {
                                                $color = 'background-color: #8a63b8 '; // azul
                                                $backgroundClass = '';
                                            }
                                            
                                            $act = formData::where('idconsulta', $item->id)
                                                ->where('tipificacion', '!=', 15)
                                                ->first();
                                            if ($act) {
                                                $azull += 1;
                                            
                                                if ($item->tipificacion == 13) {
                                                    $color = 'background-color: #bdecb6 '; // azul
                                                    $backgroundClass = '';
                                                } else {
                                                    $color = 'background-color:#b3d7f5'; // azul
                                                    $backgroundClass = '';
                                                }
                                            }
                                            if ($item->tipificacion == 13) {
                                                $color = 'background-color: #bdecb6 '; // azul
                                                $backgroundClass = '';
                                            }
                                        @endphp
                                        <tr class="{{ $backgroundClass }}" style="<?php echo $color; ?>">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->campaign_name }}</td>
                                            <td>{{ $item->form_id }}</td>
                                            <td>{{ $item->form_name }}</td>
                                            <td>{{ $item->is_organic }}</td>
                                            <td>{{ $item->platform }}</td>
                                            <td>{{ $item->cuentanos_mas_sobre_el_proyecto }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->work_phone_number }}</td>
                                            <td>{{ $item->work_email }}</td>
                                            <td>{{ $item->nombre_de_la_empresa }}</td>
                                            <td>{{ $item->job_title }}</td>

                                            <td>
                                                @if ($item->tipificacion === 1)
                                                    Nuevo
                                                @elseif ($item->tipificacion === 2)
                                                    En seguimiento
                                                @elseif ($item->tipificacion === 3)
                                                    Descartado Leads
                                                @elseif ($item->tipificacion === 5)
                                                    Leads
                                                @elseif ($item->tipificacion === 6)
                                                    Solicita Cotización
                                                @elseif ($item->tipificacion === 7)
                                                    Descartado Cotización
                                                @elseif ($item->tipificacion === 9)
                                                    Modificaciones Leads
                                                @elseif ($item->tipificacion === 10)
                                                    Modificaciones Cotización
                                                @elseif ($item->tipificacion === 11)
                                                    Seguimiento en Leads
                                                @elseif ($item->tipificacion === 12)
                                                    Tiene precio
                                                @elseif ($item->tipificacion === 13)
                                                    Acepta cotización
                                                @elseif ($item->tipificacion === 14)
                                                    Tiene análisis
                                                @elseif ($item->tipificacion === 15)
                                                    Cotización Anterior
                                                @elseif ($item->tipificacion === 16)
                                                    Recotizado
                                                @elseif ($item->tipificacion === 17)
                                                    Cotizacion Enviada
                                                @else
                                                    Desconocido
                                                @endif
                                            </td>

                                            <td
                                                style="display: flex;ex; */;justify-content: space-around;align-items: baseline;">


                                                <!---                                                                                                                                   <a href="{{ url('/leads_argentina/' . $item->id) }}"
                                                                                                                                                                                                                                                                            title="View leads_argentina" class="btn btn-info btn-sm"
                                                                                                                                                                                                                                                                            style="margin-bottom: 5px;"><i class="fas fa-envelope" aria-hidden="true"></i>
                                                                                                                                                                                                                                                                            </a>

                                                                                                                                                                                                                                                                        <a href="{{ url('/leads_argentina/' . $item->id . '/mail') }}"
                                                                                                                                                                                                                                                                            title="Enviar Cotización" class="btn btn-info btn-sm"
                                                                                                                                                                                                                                                                            style="margin-bottom: 5px;">
                                                                                                                                                                                                                                                                            <i class="fa fa-envelope" aria-hidden="true"></i> Enviar Cotización
                                                                                                                                                                                                                                                                        </a>-->
                                                <?php
                                                $act = FormData::where('idconsulta', $item->id)->first();
                                                ?>
                                                @if ($item->tipificacion != 7)
                                                    @if ($act && $act->condiciones)
                                                        <a href="{{ url('/argentina_cotiza/' . $act->id . '/mail') }}"
                                                            title="Enviar mail de cotizacion" class="btn btn-info btn-sm"
                                                            style="margin-left: 3px; margin-bottom: 5px;"><i
                                                                class="fas fa-envelope" aria-hidden="true"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ url('/argentina_cotiza/' . $item->id . '/edit') }}"
                                                        title="Editar El Lead" class="btn btn-sm"
                                                        style="margin-left: 3px; margin-bottom: 5px; background: darkorange;">
                                                        <i class="fas fa-pencil-alt"></i></a>

                                                    @if ($act)
                                                        <a href="{{ url('/argentina_cotiza/' . $item->id . '/editproyecto') }}"
                                                            title="Ingresar Datos Adicionales" class="btn btn-sm"
                                                            style="margin-left: 3px; margin-bottom: 5px; background: #f2f2f2;">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    <?php
                                                    
                                                    ?>
                                                    @if ($act && $act->condiciones)
                                                        @if ($item->tipificacion != 14)
                                                            <form id="deleteForm" method="POST"
                                                                action="{{ url('/argentina_cotiza' . '/' . $item->id) }}"
                                                                accept-charset="UTF-8">
                                                                {{ method_field('DELETE') }}
                                                                {{ csrf_field() }}

                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    title="Eliminar Cotizacion" data-toggle="modal"
                                                                    data-target="#deleteModal"
                                                                    style="margin-left: 3px; margin-bottom: 5px;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="deleteModal" tabindex="-1"
                                                                    role="dialog" aria-labelledby="deleteModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="deleteModalLabel">
                                                                                    Eliminar
                                                                                    Chile Cotiza</h5>

                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>Por favor, seleccione un motivo para la
                                                                                    eliminación:</p>
                                                                                <select id="deleteReason"
                                                                                    name="deleteReason"
                                                                                    class="form-control">
                                                                                    <option value="Costo Elevado">Costo
                                                                                        Elevado
                                                                                    </option>
                                                                                    <option value="Falta De Claridad">Falta
                                                                                        de
                                                                                        Claridad</option>
                                                                                    <option value="Competencia">Competencia
                                                                                    </option>
                                                                                    <option value="Cambios en Requisitos">
                                                                                        Cambios
                                                                                        en los Requisitos</option>
                                                                                    <option value="Tiempo de Entrega">
                                                                                        Tiempo de
                                                                                        Entrega</option>
                                                                                    <option value="Falta De Confianza">
                                                                                        Falta de
                                                                                        Confianza</option>
                                                                                    <option
                                                                                        value="Necesidades No Satisfechas">
                                                                                        Necesidades no Satisfechas</option>
                                                                                    <option
                                                                                        value="Problemas De Comunicacion">
                                                                                        Problemas de Comunicación</option>
                                                                                    <option
                                                                                        value="Experiencia Pasada Negativa">
                                                                                        Experiencia Pasada Negativa</option>
                                                                                    <option value="Cambio De Prioridades">
                                                                                        Cambio de
                                                                                        Prioridades</option>
                                                                                    <option value="Otros Problemas">Otros
                                                                                        Problemas
                                                                                    </option>
                                                                                    <option
                                                                                        value="Preferencia Otro Proveedor">
                                                                                        Preferencia por Otro Proveedor
                                                                                    </option>
                                                                                    <option value="Limitacion Presupuesto">
                                                                                        Limitación de Presupuesto</option>
                                                                                    <option value="Proyecto Aplazado">
                                                                                        Proyecto
                                                                                        Aplazado</option>
                                                                                    <option value="Error Cotizacion">Error
                                                                                        en
                                                                                        la
                                                                                        Cotización</option>
                                                                                    <option value="Cambio En Objetivos">
                                                                                        Cambio
                                                                                        en
                                                                                        los Objetivos</option>
                                                                                    <option
                                                                                        value="Insatisfaccion Anterior">
                                                                                        Insatisfacción con Trabajo Anterior
                                                                                    </option>
                                                                                    <option value="Decision Estrategica">
                                                                                        Decisión
                                                                                        Estratégica</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Cancelar</button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger"
                                                                                    onclick="submitDeleteForm()">Eliminar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @endif
                                                        <script>
                                                            function submitDeleteForm() {
                                                                var reason = document.getElementById('deleteReason').value;
                                                                if (reason.trim() === '') {
                                                                    alert('Por favor, ingrese un motivo válido.');
                                                                } else {
                                                                    document.getElementById('deleteForm').submit();
                                                                }
                                                            }
                                                        </script>
                                                        <?php
                                                    if ($act->condiciones != "") {
                                                        # code...
                                                    ?>
                                                        <a href="{{ url('/argentina_cotiza/' . $item->id . '/ver') }}"
                                                            class="btn btn-primary btn-sm d-flex align-items-center justify-content-center"
                                                            title="Ver Cotizacion"
                                                            style="margin-left: 3px; margin-bottom: 5px;">
                                                            <i class="fas fa-eye mr-2"></i>
                                                        </a>
                                                        <a href="{{ url('/argentina_cotiza/' . $act->id . '/verPDF') }}"
                                                            target="_blank" rel="noopener noreferrer"
                                                            title="Ver PDF de la Cotizacion"
                                                            class="btn btn-sm d-flex align-items-center justify-content-center"
                                                            style="background: #a94a4a;margin-left: 3px;">
                                                            <i style="color: aliceblue;" class="fas fa-file-pdf mr-2"></i>
                                                        </a>
                                                        <?php
                                                        }
                                                        
                                                                                                                ?>
                                                        @if ($item->tipificacion === 17)
                                                            <button type="button"
                                                                onclick="openFormWindow({{ $item->id }})"
                                                                title="Crear El Proyecto"
                                                                style="padding: 0px 10px; background-color: #7d7785; border: none; border-radius: 5px;height: 3%;">
                                                                <i class="fas fa-sync-alt"
                                                                    style="color: white; padding: 8px; border-radius: 50%;"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                    @if ($act and ($item->tipificacion != 14 and $item->tipificacion != 13))
                                                        <form
                                                            action="{{ url('/argentina_cotiza/' . $item->id . '/acepta') }}"
                                                            title="Acepta la Cotizacion" id="orden_trabajo_form"
                                                            style="display:inline">
                                                            <button type="submit" value="Solicitar cotización"
                                                                style="margin-left: 3px; margin-bottom: 7%;"
                                                                id="submitButton" class="btn btn-success btn-sm"
                                                                onclick="bloquearboton(this)">
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (!$act)
                                                        <button type="button"
                                                            onclick="openFormWindow({{ $item->id }})"
                                                            title="Acepta la Cotizacion"
                                                            style="margin-left: 3px; padding: 5px 10px; background-color: #8a63b8; border: none; border-radius: 5px;">
                                                            <i class="fas fa-chart-line"
                                                                style="color: white; padding: 5px; border-radius: 50%;"></i>
                                                        </button>
                                                    @endif
                                                @endif

                                                <style>
                                                    input {
                                                        margin: 4% 0 1% 0;
                                                    }

                                                    /* Estilos para la ventana flotante */
                                                    #formWindow {
                                                        position: fixed;
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(-50%, -50%);
                                                        background: #f2f2f2;
                                                        padding: 20px;
                                                        border: 1px solid #ccc;
                                                        z-index: 2;
                                                        overflow-y: auto;
                                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                                        border-radius: 5px;
                                                        width: 50%;
                                                    }

                                                    #proyectosForm label {
                                                        font-weight: bold;
                                                    }

                                                    #cantidadProyectos {
                                                        margin-bottom: 10px;
                                                    }

                                                    #finalizarButton {
                                                        background: #86B7B5;
                                                        color: white;
                                                        border: none;
                                                        padding: 10px 20px;
                                                        margin-top: 10px;
                                                        border-radius: 5px;
                                                        cursor: pointer;
                                                    }

                                                    #closeButton {
                                                        background: #f44336;
                                                        color: white;
                                                        border: none;
                                                        padding: 10px 20px;
                                                        margin-top: 10px;
                                                        border-radius: 5px;
                                                        cursor: pointer;
                                                    }
                                                </style>
                                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                                                <script>
                                                    // Función para abrir la ventana flotante
                                                    function openFormWindow(itemID) {
                                                        var windowHTML = `
                                                        <div id="formWindow" style="overflow: auto;max-height: 700px;max-width: 1000px;">
    <h2>Formulario de proyectos</h2>
    <form id="proyectosForm" action="{{ route('formulario.store') }}" method="POST">
        <input type="hidden" name="idconsulta" value="${itemID}">
        @csrf
        <label for="cantidadProyectos">Cantidad de proyectos: </label>
        <input type="number" id="cantidadProyectos" name="cantidadProyectos" min="1"
            oninput="validarCantidad(this)"><br><br>
        <div id="proyectosContainer" style="display: grid;">
            <!-- Los proyectos generados dinámicamente se agregarán aquí -->
        </div>
        <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">
    </form>
    <button id="closeButton" type="button">Cerrar</button>
</div>
                                                                `;

                                                        $('body').append(windowHTML);

                                                        // Cerrar la ventana flotante al hacer clic en el botón "Cerrar"
                                                        $('#closeButton').on('click', function() {
                                                            $('#formWindow').remove();
                                                        });

                                                        // Agregar evento de entrada para la cantidad de proyectos
                                                        $('#cantidadProyectos').on('input', function() {
                                                            var cantidad = parseInt($(this).val());
                                                            $('#proyectosContainer').empty();

                                                            for (var i = 0; i < cantidad; i++) {
                                                                var proyectoHTML = `
                                                                            <div class="proyecto" style="
    display: grid;
">
                                                                                <h3>Proyecto ${i + 1}</h3>
                                                                                <label for="nombre_proyecto">Nombre del proyecto: </label>
                                                                                <input type="text" id="nombre_proyecto" name="nombre_proyecto"><br>
                                                                                <label for="descripcion_proyecto">Descripción del proyecto: </label>
                                                                                <textarea id="descripcion_proyecto" name="descripcion_proyecto" rows="4" cols="50"></textarea>
<br>
                                                                                <label for="cantidadModulos">Cantidad de módulos: </label>
                                                                                <input type="number" id="cantidadModulos${i}" name="cantidad_modulos" min="1" max="5"><br>
                                                                                <div id="modulos${i}"></div><br>
                                                                            </div>
                                                                        `;

                                                                $('#proyectosContainer').append(proyectoHTML);
                                                            }
                                                        });

                                                        // Agregar evento de entrada para la cantidad de módulos dentro de cada proyecto
                                                        $(document).on('input', '[id^="cantidadModulos"]', function() {
                                                            var proyectoId = $(this).attr('id').replace('cantidadModulos', '');
                                                            var cantidadModulos = parseInt($(this).val());
                                                            var modulosHTML = '';

                                                            for (var j = 0; j < cantidadModulos; j++) {
                                                                var moduloHTML = `
                                                                            <div class="modulo" style="display: grid;">
                                                                                <h4>Módulo ${j + 1}</h4>
                                                                                <label for="nombre_modulo_${j}">Nombre del módulo: </label>
                                                                                <input type="text" id="nombre_modulo_${j}_1" name="nombre_modulo_${j}_1"><br>
                                                                                <label for="descripcion_modulo_${j}">Descripción del módulo: </label>
                                                                                <textarea id="descripcion_modulo_${j}_1" name="descripcion_modulo_${j}_1" rows="4" cols="50"></textarea><br>

                                                                                <label for="cantidadProcesos_${j}">Cantidad de procesos: </label>
                                                                                <input type="number" id="cantidadProcesos${proyectoId}_${j}" name="cantidadProcesos${proyectoId}_${j}" min="1" max="5"><br>
                                                                                <div id="procesos${proyectoId}_${j}"></div><br>
                                                                            </div>
                                                                        `;

                                                                modulosHTML += moduloHTML;
                                                            }

                                                            $('#modulos' + proyectoId).html(modulosHTML);

                                                            // Agregar evento de entrada para la cantidad de procesos dentro del módulo
                                                            $('[id^="cantidadProcesos' + proyectoId + '_"]').on('input', function() {
                                                                var id = $(this).attr('id');
                                                                var moduloId = id.substring(id.indexOf('_') + 1);
                                                                var cantidadProcesos = parseInt($(this).val());
                                                                var procesosContainer = $('#procesos' + proyectoId + '_' + moduloId);
                                                                var procesosHTML = '';

                                                                for (var k = 0; k < cantidadProcesos; k++) {
                                                                    var procesoHTML = `
                                                                                <div class="proceso" style="display: grid;">
                                                                                    <h5>Proceso ${k + 1}</h5>
                                                                                    <label for="nombre_proceso_${k}">Nombre del proceso: </label>
                                                                                    <input type="text" id="nombre_proceso_${k+1}_${moduloId}" name="nombre_proceso_${k+1}_${moduloId}"><br>
                                                                                    <label for="descripcion_proceso_${k}">Descripción del proceso: </label>
                                                                                    <textarea id="descripcion_proceso_${k+1}_${moduloId}" name="descripcion_proceso_${k+1}_${moduloId}" rows="4" cols="50"></textarea><br>

                                                                                </div>
                                                                            `;

                                                                    procesosHTML += procesoHTML;
                                                                }

                                                                procesosContainer.html(procesosHTML);
                                                            });
                                                        });

                                                        // Enviar formulario sin recargar la página al presionar "Finalizar"

                                                    }
                                                </script>

                                            </td>
                                            <script>
                                                function validarCantidad(input) {
                                                    var valor = parseInt(input.value);

                                                    if (valor > 1) {
                                                        alert("Solo se puede agregar 1 proyecto.");
                                                        input.value = 1;
                                                    }
                                                }
                                            </script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#proyectosForm').on('submit', function(e) {
                                                        e.preventDefault(); // Evita el envío normal del formulario

                                                        var formData = $(this).serialize(); // Serializa los datos del formulario

                                                        $.ajax({
                                                            url: $(this).attr('action'),
                                                            type: $(this).attr('method'),
                                                            data: formData,
                                                            success: function(response) {
                                                                $('#responseMessage').html(
                                                                    '<div class="alert alert-success">Los datos se han guardado correctamente.</div>'
                                                                );
                                                            },
                                                            error: function(xhr, status, error) {
                                                                $('#responseMessage').html(
                                                                    '<div class="alert alert-danger">Hubo un problema al guardar los datos.</div>'
                                                                );
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination">
                                {{ $leadsPaginator->appends(request()->query())->links() }}
                                <!-- Mostrar enlaces de paginación con parámetros de consulta -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
