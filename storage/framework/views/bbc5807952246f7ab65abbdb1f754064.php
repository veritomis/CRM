<?php
use App\Models\usuarios;

use App\Models\roles;
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
    </style>
    <style>
        .alert-success {
            background-color: #86B7B5;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <nav class="navbar bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="padding-left: 4px;padding-right: 4px; margin-right: 10px;">
                <span class="navbar-toggler-icon display-6">☰</span>
            </button>
            <h2 class="me-auto">Listado de Roles</h2>
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

                            <h5>Otras opciones</h5>
                            <a href="<?php echo e(route('cac.agenda')); ?>" class="nav-link" style="margin-right: 10px;">Agenda</a>



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
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(url('/roles/create')); ?>" class="btn btn-success btn-sm" title="Añadir nuevo roles">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
                            </a>
                        </div>
                        <br />
                        <br />
                        <?php if(session('message')): ?>
                            <div class="alert alert-success"><?php echo e(session('message')); ?></div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="custom-table" style="text-align: center;">
                                <thead style="background-color: #007BFF;">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Permiso Usuario</th>
                                        <th>Permiso Roles</th>
                                        <th>Permiso Leads</th>
                                        <th>Permiso Agenda</th>
                                        <th>Permiso Cotiza</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->nombre); ?></td>
                                            <td><?php echo e($item->descripcion); ?></td>
                                            <td><?php echo e($item->usuarios ? 'Si' : 'No'); ?></td>
                                            <td><?php echo e($item->roles ? 'Si' : 'No'); ?></td>
                                            <td><?php echo e($item->leads ? 'Si' : 'No'); ?></td>
                                            <td><?php echo e($item->agenda ? 'Si' : 'No'); ?></td>
                                            <td><?php echo e($item->cotiza ? 'Si' : 'No'); ?></td>
                                            <td class="acciones">
                                          
                                                <div class="boton">
                                                <a href="<?php echo e(url('/roles/' . $item->id)); ?>" title="Ver rol"
                                                    class="btn btn-info btn-sm" style="margin-bottom: 5px;"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                </div>
                                                <div class="boton">
                                                <a href="<?php echo e(url('/roles/' . $item->id . '/edit')); ?>" title="Editar rol"
                                                    class="btn btn-sm" style="margin-bottom: 5px;background: darkorange;">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                </div>
                                                <div class="boton">
                                                 
                                                <?php if($item->usuarios()->count() === 0): ?>
                                                    <form method="POST" action="<?php echo e(url('/roles' . '/' . $item->id)); ?>"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        <?php echo e(method_field('DELETE')); ?>

                                                        <?php echo e(csrf_field()); ?>

                                                        <button title="Eliminar Rol" type="button"
                                                            class="btn btn-danger btn-sm" data-toggle="modal"
                                                            data-target="#confirmDeleteModal" style="margin-bottom: 5px">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                 
                                                </div>
                                            
                                                        <!-- Modal de confirmación de eliminación -->
                                                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="confirmDeleteModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="confirmDeleteModalLabel">Confirmar
                                                                            Eliminación</h5>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        ¿Estás seguro de que deseas eliminar ? Esta acción
                                                                        no se puede deshacer.
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                        <!-- Agrega el botón de eliminación aquí -->
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Eliminar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       

                                                    </form>
                                                   
                                                <?php endif; ?>
                                              
                                            </td>
                                           
                                        </tr>
                                     
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('roles.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/roles/index.blade.php ENDPATH**/ ?>