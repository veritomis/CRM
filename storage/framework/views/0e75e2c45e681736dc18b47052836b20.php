<?php $__env->startSection('content'); ?>

    <style>
        .alert-success {
            background-color: #86B7B5;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <div class="card">

        <div class="card-header">Visualización de Leads Argentina</div>

        <div class="card-body">
            <div class="card-body">
                <h5>Nombre de Campaña: <?php echo e($leads_argentina->campaign_name); ?></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Organizacion</th>
                            <th>Plataforma</th>
                            <th>Proyecto</th>
                            <th>Nombre Cliente</th>
                            <th>Celular</th>
                            <th>email</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <!-- Agrega más encabezados de columna aquí -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($leads_argentina->form_id); ?></td>
                            <td><?php echo e($leads_argentina->form_name); ?></td>
                            <td><?php echo e($leads_argentina->is_organic); ?></td>
                            <td><?php echo e($leads_argentina->platform); ?></td>
                            <td><?php echo e($leads_argentina->cuentanos_mas__sobre_el_proyecto); ?></td>
                            <td><?php echo e($leads_argentina->full_name); ?></td>
                            <td><?php echo e($leads_argentina->work_phone_number); ?></td>
                            <td><?php echo e($leads_argentina->work_email); ?></td>
                            <td><?php echo e($leads_argentina->nombre_de_la_empresa); ?></td>
                            <td><?php echo e($leads_argentina->job_title); ?></td>
                            <!-- Agrega más celdas de datos aquí para cada columna -->
                        </tr>
                    </tbody>
                </table>
            </div>
            </hr>
            <a href="<?php echo e(url('leads_argentina')); ?>" class="btn btn-secondary">Volver</a>

        </div>
        <div class="card-body">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10" style="width: 90%;">
                        <h5 style="margin-bottom: 0px; padding-bottom: 0px;">Visualización de Acciones</h5>
                    </div>
                    <div class="col-md-1 text-right">
                        <a href="<?php echo e(url('/acciones_argentina/create', ['LeadsArgentina' => $leads_argentina->id])); ?>"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <table class="custom-table" style="text-align: center;">
                    <thead style="background-color: #007BFF;">
                        <tr>
                            <th>Nombre</th>
                            <th>Comentario</th>
                            <th>Evidencia 1</th>
                            <th>Evidencia 2</th>
                            <th>Creado por</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $acciones_argentina; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($accion->accion); ?></td>
                                <td><?php echo e($accion->comentario); ?></td>
                                <td>
                                    <?php if($accion->documento1): ?>
                                        <a href="<?php echo e(asset('storage/' . $accion->documento1)); ?>" target="_blank"
                                            class="btn btn-primary">
                                            Ver archivo
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($accion->documento2): ?>
                                        <a href="<?php echo e(asset('storage/' . $accion->documento2)); ?>" target="_blank"
                                            class="btn btn-primary">
                                            Ver archivo
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($usuarios[intval($accion->usuario)]); ?></td>
                                <td><?php echo e($accion->created_at); ?></td>
                                <td>
                                    <a href="<?php echo e(url('/acciones_argentina/' . $accion->id)); ?>" title="View acciones"
                                        class="btn btn-info btn-sm"><i class="fas fa-envelope" aria-hidden="true"></i>
                                        Vista</a>
                                    
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

<?php echo $__env->make('leads_argentina.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/leads_argentina/show.blade.php ENDPATH**/ ?>