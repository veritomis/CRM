<?php
use App\Models\usuarios;
use App\Models\chile;
use App\Models\roles;
use App\Models\FormDataCle;
use App\Models\ReporteDiario;
use Illuminate\Pagination\Paginator;

?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <style>
        .alert-success {
            background-color: #86B7B5;
            color: white;
        }
        .container-proyecto{
            background-color: #91ABCE;
            padding-left: 1%;
            padding-right:1%;
        }
        .container-modulos{
            background-color: #B9CE91;
            padding-left: 3%;
            padding-right:1%;
        }
        .container-procesos{
            background-color: #9193CE;
            padding-left: 4%;
            padding-right:1%;
        }
        .botones{
            display: inline-block;
        }
        /* Estilos para los botones */
        .guardar, .cerrar {
            width: 150px;
            height: 40px; /* Establece un alto fijo para los botones */
            margin: 5px;
        }
        .cerrar {
            border: 0; /* Establece el margen a 0 para el botón "Cerrar" */
        }
        .guardar{
            color: white;
            background-color: #5B9F60;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer; 
        }
        
    </style>
    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Asegúrate de incluir SweetAlert2 y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <nav class="navbar bg-light fixed-top">
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Cotizacion Chile</h2>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel" style="visibility: visible;width: 200px;">
                <img src="<?php echo e(asset('storage/Logo_unbc_color.png')); ?>" alt="logo"
                    style="max-width: 180px; max-height: 180px; margin-left: 6px;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php echo e(session('usuario')); ?></h5>
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

                            <h5>Otras opciones</h5><a href="<?php echo e(route('cac.agenda')); ?>" class="nav-link"
                                style="margin-right: 10px;">Agenda</a>



                            <?php
            } ?>
                        </li>

                        <li class="nav-item dropdown" style="margin-top: 25%;">
                            <form action="<?php echo e(url('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
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
                        <form action="<?php echo e(request()->url()); ?>" method="get">
                            <div class="form-group">
                                <label for="tipificacion">Seleccionar Estado:</label>
                                <select name="tipificacion" id="tipificacion" class="form-control">
                                    <option value="0"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '0' ? 'selected' : ''); ?>>
                                        Todas las tipificaciones</option>
                                    <option value="13"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '13' ? 'selected' : ''); ?>>
                                        Acepta</option>
                                    <option value="6"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '6' ? 'selected' : ''); ?>>
                                        Solicita Cotizacion</option>
                                    <option value="14"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '14' ? 'selected' : ''); ?>>
                                        Tiene análisis</option>
                                    <option value="22"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '22' ? 'selected' : ''); ?>>
                                        En seguimiento</option>
                                    <option value="18"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '18' ? 'selected' : ''); ?>>
                                        Cotizaciones Listas</option>
                                    <option value="17"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '17' ? 'selected' : ''); ?>>
                                        Cotizaciones Enviadas</option>
                                    <option value="7"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '7' ? 'selected' : ''); ?>>
                                        Descartado</option>
                                    <option value="20"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '20' ? 'selected' : ''); ?>>
                                        Cotizaciones Rechazadas</option>
                                    <option value="21"
                                        <?php echo e(isset($_GET['tipificacion']) && $_GET['tipificacion'] == '21' ? 'selected' : ''); ?>>
                                        Cotizaciones Aprobadas</option>
                                    <!-- Agrega más opciones de tipificación según tus necesidades -->
                                </select>
                            </div>
                            </div>
                            
                            <div class="col-4">
                            <button style="margin-top: 1%" type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                           
                            
                        </form>
                        </div>
                        </div>
                        <br />
                        <br />

                        <?php if(session('message')): ?>
                            <div class="alert alert-success"><?php echo e(session('message')); ?></div>
                        <?php endif; ?>

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
                                    <?php
                                        // Ordenar la colección de leads en la vista
                                        // Ordenar la colección de leads en la vista
                                        $perPage = 10;
                                        $currentPage = request()->get('page', 1); // Obtiene el número de página actual
                                        
                                        $chile_cotiza = $chile_cotiza->sortBy(function ($lead) {
                                            // Primero, ordenar por tipificación
                                            return $lead->tipificacion;
                                        });
                                        
                                        /*$chile_cotiza = $chile_cotiza->sortBy('updated_at')->sortBy(function ($lead) {
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
                                        
                                        $pagedData = $chile_cotiza->forPage($currentPage, $perPage);
                                        $leadsPaginator = new \Illuminate\Pagination\LengthAwarePaginator($pagedData, $chile_cotiza->count(), $perPage, $currentPage);
                                        $leadsPaginator->setPath(request()->url()); // Establece la URL base para la paginación
                                    ?>
                                    <?php $__currentLoopData = $leadsPaginator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
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
                                                $color = 'background-color: #F8C3BD'; // era naranja ahora es mas traslucido
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
                                                $color = 'background-color: #D1B9EE '; // lila suave
                                                $backgroundClass = '';
                                            }
                                            
                                            $act = FormDataCle::where('idconsulta', $item->id)
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
                                        ?>
                                        <tr class="<?php echo e($backgroundClass); ?>" style="<?php echo $color; ?>">
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->campaign_name); ?></td>
                                            <td><?php echo e($item->form_id); ?></td>
                                            <td><?php echo e($item->form_name); ?></td>
                                            <td><?php echo e($item->is_organic); ?></td>
                                            <td><?php echo e($item->platform); ?></td>
                                            <td><?php echo e($item->cuentanos_sobre_el_proyecto); ?></td>
                                            <td><?php echo e($item->full_name); ?></td>
                                            <td><?php echo e($item->phone_number); ?></td>
                                            <td><?php echo e($item->email); ?></td>
                                            <td><?php echo e($item->company_name); ?></td>
                                            <td><?php echo e($item->job_title); ?></td>

                                            <td>
                                                <?php if($item->tipificacion === 1): ?>
                                                    Nuevo
                                                <?php elseif($item->tipificacion === 2): ?>
                                                    En seguimiento
                                                <?php elseif($item->tipificacion === 3): ?>
                                                    Descartado Leads
                                                <?php elseif($item->tipificacion === 5): ?>
                                                    Leads
                                                <?php elseif($item->tipificacion === 6): ?>
                                                    Solicita Cotización
                                                <?php elseif($item->tipificacion === 7): ?>
                                                    Descartado Cotización
                                                <?php elseif($item->tipificacion === 9): ?>
                                                    Modificaciones Leads
                                                <?php elseif($item->tipificacion === 10): ?>
                                                    Modificaciones Cotización
                                                <?php elseif($item->tipificacion === 11): ?>
                                                    Seguimiento en Leads
                                                <?php elseif($item->tipificacion === 12): ?>
                                                    Tiene precio
                                                <?php elseif($item->tipificacion === 13): ?>
                                                    Acepta cotización
                                                <?php elseif($item->tipificacion === 14): ?>
                                                    Tiene análisis
                                                <?php elseif($item->tipificacion === 15): ?>
                                                    Cotización Anterior
                                                <?php elseif($item->tipificacion === 16): ?>
                                                    Recotizado
                                                <?php elseif($item->tipificacion === 17): ?>
                                                    Cotizaciones Enviadas
                                                <?php elseif($item->tipificacion === 18): ?>
                                                    Cotizacion Lista
                                                <?php elseif($item->tipificacion === 19): ?>
                                                    Nueva Cotización Enviada
                                                <?php elseif($item->tipificacion === 20): ?>
                                                    Cotizaciones Rechazadas
                                                <?php elseif($item->tipificacion === 21): ?>
                                                    Cotizaciones Aprobadas
                                                <?php elseif($item->tipificacion === 22): ?>
                                                    Cotizaciones en Seguimiento     
                                                <?php else: ?>
                                                    Desconocido
                                                <?php endif; ?>
                                            </td>

                                            <td
                                                style="display: flex;ex; */;justify-content: space-around;align-items: baseline;">


                                                <!---                                                                                                                                   <a href="<?php echo e(url('/leads_argentina/' . $item->id)); ?>"
                                                                                                                                                                                                                                                            title="View leads_argentina" class="btn btn-info btn-sm"
                                                                                                                                                                                                                                                            style="margin-bottom: 5px;"><i class="fas fa-envelope" aria-hidden="true"></i>
                                                                                                                                                                                                                                                            </a>

                                                                                                                                                                                                                                                        <a href="<?php echo e(url('/leads_argentina/' . $item->id . '/mail')); ?>"
                                                                                                                                                                                                                                                            title="Enviar Cotización" class="btn btn-info btn-sm"
                                                                                                                                                                                                                                                            style="margin-bottom: 5px;">
                                                                                                                                                                                                                                                            <i class="fa fa-envelope" aria-hidden="true"></i> Enviar Cotización
                                                                                                                                                                                                                                                        </a>-->
                                                <?php
                                                $act = FormDataCle::where('idconsulta', $item->id)->first();
                                                ?>
                                                <?php if($item->tipificacion != 7): ?>
                                                    <?php if($act && $act->condiciones): ?>
                                                        <a href="<?php echo e(url('/chile_cotiza/' . $act->id . '/mail')); ?>"
                                                            title="Enviar mail de cotizacion" class="btn btn-info btn-sm"
                                                            style="margin-left: 3px; margin-bottom: 5px;"><i
                                                                class="fas fa-envelope" aria-hidden="true"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(url('/chile_cotiza/' . $item->id . '/edit')); ?>"
                                                        title="Editar El Lead" class="btn btn-sm"
                                                        style="margin-left: 3px; margin-bottom: 5px; background: darkorange;">
                                                        <i class="fas fa-pencil-alt"></i></a>

                                                    <?php if($act): ?>
                                                        <a href="<?php echo e(url('/chile_cotiza/' . $item->id . '/editproyecto')); ?>"
                                                            title="Ingresar Datos Financieros" class="btn btn-sm"
                                                            style="display: none;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                                            </svg>
                                                             <!--margin-left: 3px; margin-bottom: 5px; background: #f2f2f2;-->
                                                            <!--<i class="fas fa-edit"></i>-->
                                                        </a>
                                                    <?php endif; ?>
                                                     <!--este if a continuación 10.11.23 lo puse para que el boton $ de cotizacion aparezca en tiene analisis, acepta cotizacion y recotizado-->
                                                     <?php if($act && $act->condiciones): ?>
                                                        <?php if($item->tipificacion === 13 || $item->tipificacion === 14 || $item->tipificacion === 16): ?>
                                                        <a href="<?php echo e(url('/chile_cotiza/' . $item->id . '/editproyecto')); ?>"
                                                            title="Ingresar Datos Financieros" class="btn btn-sm"
                                                            style="margin-left: 3px; margin-bottom: 5px; background: #f2f2f2;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                                            </svg>
                                                        </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>     
                                                    <?php
                                                    
                                                    ?>
                                                    <?php if($act && $act->condiciones): ?>
                                                        <?php if($act->condiciones and $item->tipificacion != 14): ?>
                                                            <form id="deleteForm" method="POST"
                                                                action="<?php echo e(url('/chile_cotiza' . '/' . $item->id)); ?>"
                                                                accept-charset="UTF-8">
                                                                <?php echo e(method_field('DELETE')); ?>

                                                                <?php echo e(csrf_field()); ?>


                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    title="Eliminar Cotizacion" data-toggle="modal"
                                                                    data-target="#deleteModal"
                                                                    style="margin-left: 3px; margin-bottom: 5px;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                        <?php endif; ?>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="deleteModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="deleteModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel">
                                                                            Eliminar
                                                                            Chile Cotiza</h5>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Por favor, seleccione un motivo para la
                                                                            eliminación:</p>
                                                                        <select id="deleteReason" name="deleteReason"
                                                                            class="form-control">
                                                                            <option value="Costo Elevado">Costo Elevado
                                                                            </option>
                                                                            <option value="Falta De Claridad">Falta de
                                                                                Claridad</option>
                                                                            <option value="Competencia">Competencia
                                                                            </option>
                                                                            <option value="Cambios en Requisitos">
                                                                                Cambios
                                                                                en los Requisitos</option>
                                                                            <option value="Tiempo de Entrega">Tiempo de
                                                                                Entrega</option>
                                                                            <option value="Falta De Confianza">Falta de
                                                                                Confianza</option>
                                                                            <option value="Necesidades No Satisfechas">
                                                                                Necesidades no Satisfechas</option>
                                                                            <option value="Problemas De Comunicacion">
                                                                                Problemas de Comunicación</option>
                                                                            <option value="Experiencia Pasada Negativa">
                                                                                Experiencia Pasada Negativa</option>
                                                                            <option value="Cambio De Prioridades">
                                                                                Cambio de
                                                                                Prioridades</option>
                                                                            <option value="Otros Problemas">Otros
                                                                                Problemas
                                                                            </option>
                                                                            <option value="Preferencia Otro Proveedor">
                                                                                Preferencia por Otro Proveedor</option>
                                                                            <option value="Limitacion Presupuesto">
                                                                                Limitación de Presupuesto</option>
                                                                            <option value="Proyecto Aplazado">Proyecto
                                                                                Aplazado</option>
                                                                            <option value="Error Cotizacion">Error en
                                                                                la
                                                                                Cotización</option>
                                                                            <option value="Cambio En Objetivos">Cambio
                                                                                en
                                                                                los Objetivos</option>
                                                                            <option value="Insatisfaccion Anterior">
                                                                                Insatisfacción con Trabajo Anterior
                                                                            </option>
                                                                            <option value="Decision Estrategica">
                                                                                Decisión
                                                                                Estratégica</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                        <button type="button" class="btn btn-danger"
                                                                            onclick="submitDeleteForm()">Eliminar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
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
                                                    ?>
                                                        <a href="<?php echo e(url('/chile_cotiza/' . $item->id . '/ver')); ?>"
                                                            class="btn btn-primary btn-sm d-flex align-items-center justify-content-center"
                                                            title="Ver Cotizacion"
                                                            style="margin-left: 3px; margin-bottom: 5px;">
                                                            <i class="fas fa-eye mr-2"></i>
                                                        </a>
                                                        <a href="<?php echo e(url('/chile_cotiza/' . $act->id . '/verPDF')); ?>"
                                                            target="_blank" rel="noopener noreferrer"
                                                            title="Ver PDF de la Cotizacion"
                                                            class="btn btn-sm d-flex align-items-center justify-content-center"
                                                            style="background: #a94a4a;margin-left: 3px;">
                                                            <i style="color: aliceblue;" class="fas fa-file-pdf mr-2"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php if($item->tipificacion === 17): ?>
                                                            
                                                    <button type="button" onclick="mostrarNuevosBotones(<?php echo e($item->id); ?>)" id="<?php echo e('mostrarBotones'. $item->id); ?>" 
                                                                title="Recotizar Proyecto"
                                                                style="padding: 0px 10px; background-color: #7d7785; border: none; border-radius: 5px;height: 3%;">
                                                                <i class="fas fa-sync-alt"
                                                                    style="color: white; padding: 8px; border-radius: 50%;"></i>
                                                        </button>
                                                                                                               
                                                        <!--<button type="button"
                                                                onclick="openFormWindow(<?php echo e($item->id); ?>)"
                                                                title="Recotizar Proyecto"
                                                                style="padding: 0px 10px; background-color: #7d7785; border: none; border-radius: 5px;height: 3%;">
                                                                <i class="fas fa-sync-alt"
                                                                    style="color: white; padding: 8px; border-radius: 50%;"></i>
                                                            </button>-->
                                                        <?php endif; ?>
                                                        <div id="<?php echo e('contenedorBotones'. $item->id); ?>" style="display: none;">                                                        
                                                            <a href="<?php echo e(url('/chile_cotiza/' . $item->id . '/editproyecto')); ?>"
                                                                title="Ingresar Datos Financieros" class="btn btn-sm"
                                                                style="margin-left: 3px; margin-bottom: 5px; background: #f2f2f2;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                                                                </svg>
                                                            </a>
                                                            <button type="button"
                                                            onclick="openFormWindow(<?php echo e($item->id); ?>)"
                                                            title="Crear Análisis"
                                                            style="margin-left: 3px; padding: 5px 10px; background-color: #8a63b8; border: none; border-radius: 5px;">
                                                            <i class="fas fa-chart-line"
                                                                style="color: white; padding: 5px; border-radius: 50%;"></i>
                                                        </button>
                                                            
                                                        <!--<button type="button" id="<?php echo e('reformularButton'. $item->id); ?>" onclick="reformularProyecto(<?php echo e($item->id); ?>)"style="padding: -1px 10px; background-color: #DDCBF5; border: solid; border-radius: 5px;height: 3%;">Reformula Análisis</button>
                                                            <button type="button" id="<?php echo e('recotizarButton'. $item->id); ?>"  onclick="recotizarTarifas(<?php echo e($item->id); ?>)"style="padding: 0px 10px; background-color: #DDCBF5; border: solid; border-radius: 5px;height: 3%;">Recotizar Tarifas</button>-->
                                                        </div>
                                                        
                                                        <?php endif; ?>    
                                                    <?php if($act and ($item->tipificacion != 14 and $item->tipificacion != 13)): ?>
                                                        <!--<form action="<?php echo e(url('/chile_cotiza/' . $item->id . '/acepta')); ?>"
                                                            title="Crea Análisis" id="orden_trabajo_form"
                                                            style="display:inline">
                                                            <button type="submit" value="Solicitar cotización"
                                                                style="margin-left: 3px; margin-bottom: 7%;"
                                                                id="submitButton" class="btn btn-success btn-sm">
                                                                onclick="bloquearboton(this)"
                                                                <i class="fas fa-check-circle"></i>
                                                            </button>
                                                        </form>-->
                                                    <?php endif; ?>
                                                    <?php if(!$act): ?>
                                                        <button type="button"
                                                            onclick="openFormWindow(<?php echo e($item->id); ?>)"
                                                            title="Crear Análisis"
                                                            style="margin-left: 3px; padding: 5px 10px; background-color: #8a63b8; border: none; border-radius: 5px;">
                                                            <i class="fas fa-chart-line"
                                                                style="color: white; padding: 5px; border-radius: 50%;"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>

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
<form id="proyectosForm" action="<?php echo e(route('formulario2.store')); ?>" method="POST">
    <input type="hidden" name="idconsulta" value="${itemID}">
    <?php echo csrf_field(); ?>
    <div class="container-proyecto">
    <label for="cantidadProyectos">Cantidad de proyectos: </label>
    <input type="number" id="cantidadProyectos" name="cantidadProyectos" min="1"
        oninput="validarCantidad(this)"><br><br>
    <div id="proyectosContainer" style="display: grid;">
        <!-- Los proyectos generados dinámicamente se agregarán aquí -->
    </div>
    <div class="botones">
    <!-- <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">-->
    <input type="submit" value="Guardar" id="submitButton" class="guardar">
    <button id="closeButton" type="button" class="cerrar">Cerrar</button>
    </div>
</form>

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
<div class="container-modulos">
                                                                            <label for="cantidadModulos">Cantidad de módulos: </label>
                                                                            <input type="number" id="cantidadModulos${i}" name="cantidad_Modulos" min="1" max="5"><br>
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

                                                                            <label for="cantidadProcesos_${j}">Cantidad de procesos / Interfaces: </label>
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
                                                                            <div class="container-procesos">    
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
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <?php echo e($leadsPaginator->appends(request()->query())->links()); ?>

                                <!-- Mostrar enlaces de paginación con parámetros de consulta -->
                            </div>
                         
                   
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>    
    function mostrarNuevosBotones(nombre) {
        const mostrarBotonesButton = document.getElementById('mostrarBotones'+ nombre);
        const contenedorBotones = document.getElementById('contenedorBotones'+ nombre);
        if (contenedorBotones) {
        var modalStyle = contenedorBotones.style;

        if (modalStyle.display === 'none' || modalStyle.display === '') {
            modalStyle.display = 'block'; // o el valor que desees
        } else {
            modalStyle.display = 'none';
        }
    }
        
    }
    </script>             
<?php $__env->stopSection(); ?>

<?php echo $__env->make('leads_chile.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/chile_cotiza/index.blade.php ENDPATH**/ ?>