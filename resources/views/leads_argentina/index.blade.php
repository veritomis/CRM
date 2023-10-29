<?php
use App\Models\usuarios;
use Illuminate\Pagination\Paginator;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .col-md-4.text-center {
            margin: 0 2% 2% 0;
        }

        .mb-3 {
            margin-bottom: 0rem !important;
        }
    </style>

    @include('flash::message')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <nav class="navbar bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Leads Argentina</h2>
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
                            <a style="margin-right: 1%;" href="{{ url('/leads_argentina/create') }}"
                                class="btn btn-success btn-sm" title="Añadir nuevo Lead">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                                
                            <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="excel_file" id="excel_file">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Subir Excel</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                       
                        <script>                                                     
                            document.addEventListener('DOMContentLoaded', function() {
                            var fileInput = document.getElementById('excel_file');

                            fileInput.addEventListener('change', function() {
                                var filePath = fileInput.value;
                                var allowedExtensions = /(\.xls|\.xlsx)$/i;

                                if (!filePath) {
                                    // No se ha seleccionado ningún archivo
                                    alert('Por favor, selecciona un archivo Excel.');
                                    return false;
                                }

                                if (!allowedExtensions.exec(filePath)) {
                                    console.log('Por favor, carga un archivo Excel válido (xls o xlsx).');
                                    alert('Por favor, carga un archivo Excel válido (xls o xlsx).');
                                    fileInput.value = '';
                                    return false;
                                }
                            });
                        });
                       
                        </script>
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
                                    <option value="1"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '1' ? 'selected' : '' }}>
                                        Nuevo</option>
                                    <option value="2"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '2' ? 'selected' : '' }}>
                                        En seguimiento</option>
                                    <option value="3"
                                        {{ isset($_GET['tipificacion']) && $_GET['tipificacion'] == '3' ? 'selected' : '' }}>
                                        Descartado</option>

                                    <!-- Agrega más opciones de tipificación según tus necesidades -->
                                </select>
                                </div>
                            </div>
                            <div class="col-4">
                            <button style="margin-top: 1%" type="submit" class="btn btn-primary">Filtrar</button></div>
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
                                        <th>Formulario</th>
                                        <th>Formulario</th>
                                        <th>Organización</th>
                                        <th>Plataforma</th>
                                        <th>Informacion del proyecto</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Empresa</th>
                                        <th>Puesto</th>
                                        <th>N° de Seguimientos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Ordenar la colección de leads en la vista
                                        $perPage = 10;
                                        $currentPage = request()->get('page', 1); // Obtiene el número de página actual
                                        $leads_argentina = $leads_argentina->sortBy('updated_at')->sortBy(function ($lead) {
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
                                        
                                        $pagedData = $leads_argentina->forPage($currentPage, $perPage);
                                        $leadsPaginator = new \Illuminate\Pagination\LengthAwarePaginator($pagedData, $leads_argentina->count(), $perPage, $currentPage);
                                        $leadsPaginator->setPath(request()->url()); // Establece la URL base para la paginación
                                    @endphp
                                    @foreach ($leadsPaginator as $item)
                                        {{-- @foreach ($leads_argentina as $item) --}}
                                        @php
                                            $color = '';
                                            // Establecer la clase CSS para el color de fondo según las condiciones
                                            $backgroundClass = '';
                                            if ($item->cotizacion == 0 && $item->num_acciones > 0) {
                                                $backgroundClass = 'bg-warning'; // Amarillo
                                            } elseif ($item->cotizacion == 1) {
                                                $backgroundClass = 'bg-success'; // Verde
                                            }
                                            
                                            if ($item->tipificacion == 3) {
                                                $color = 'background-color: #ec7575'; // Verde
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
                                            <td>{{ $item->num_acciones }}</td>
                                            <td>
                                                <!----<div class="row mb-3">
                                                                        <div class="col-md-4 text-center">
                                                                            <a href="{{ url('/acciones_argentina/create', ['LeadsArgentina' => $item->id]) }}"
                                                                                class="btn btn-primary btn-sm">
                                                                                <i class="fas fa-plus"></i>
                                                                            </a>
                                                                        </div>--->
                                                <div class="col-md-4 text-center">
                                                    <a href="{{ url('/leads_argentina/' . $item->id) }}" title="Ver Lead"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                        <!-- Icono de bocina, era ahora es un ojo-->
                                                    </a>
                                                </div>

                                                <div class="col-md-4 text-center">
                                                    <a href="{{ url('/leads_argentina/' . $item->id . '/edit') }}"
                                                        title="Editar Lead" class="btn btn-sm"
                                                        style="background: darkorange;">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 text-center">
                                <form method="POST" action="{{ url('/leads_argentina' . '/' . $item->id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button title="Eliminar Lead" type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal" data-target="#confirmDeleteModal">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar
                                                        Eliminación</h5>

                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar ? Esta acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancelar</button>
                                                    <!-- Agrega el botón de eliminación aquí -->
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 text-center">
                                @if ($item->cotizacion == 0)
                                    <form action="{{ url('/solicitar_cotizacion/arg/' . $item->id) }}"
                                        id="orden_trabajo_form" style="display:inline">
                                        <button title="Solicitar Cotizacion" type="submit" value="Solicitar cotización"
                                            id="submitButton" class="btn btn-success btn-sm"
                                            onclick="bloquearboton(this)">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>

                                    <script>
                                        function bloquearboton(button) {
                                            const form = document.getElementById('orden_trabajo_form');
                                            button.disabled = true;
                                            form.submit();
                                        }
                                    </script>
                                @else
                                @endif
                                </td>
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
        <!-- Incluye jQuery antes de este código -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        <script>
            // Evento click para el botón
            $(document).ready(function() {
                $('#openFormButton').on('click', function(event) {
                    event.preventDefault(); // Evita que el formulario se envíe al hacer clic en el botón
                    openFormWindow(); // Llama a la función openFormWindow()
                });
            });

            // Resto del código JavaScript aquí (la función openFormWindow() se mantiene igual)
        </script>
    @endsection


