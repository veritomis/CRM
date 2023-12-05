<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>


    <div class="card">
        <div class="card-header">Visualización de Accion</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Nombre: <?php echo e($acciones->accion); ?></h5>
                <p class="card-text">Comentario: <?php echo e($acciones->comentario); ?></p>

                <p class="card-text">Evidencia 1: 
                    <?php if($acciones->documento1): ?>
                    <a href="<?php echo e(asset('storage/evidencias/' . $acciones->documento1)); ?>" target="_blank" class="btn btn-primary">
                        Ver archivo
                    </a>
                    <?php endif; ?>
                </p>
                <p class="card-text">Evidencia 2: 
                    <?php if($acciones->documento2): ?>
                    <a href="<?php echo e(asset('storage/evidencias/' . $acciones->documento2)); ?>" target="_blank" class="btn btn-primary">
                        Ver archivo
                    </a>
                    <?php endif; ?>
                </p>
                <p class="card-text">Creado por: <?php echo e($usuarios[intval($acciones->usuario)]); ?></p>
                <p class="card-text">Creado el: <?php echo e($acciones->created_at); ?></p>
            </div>

            </hr>
            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>

        </div>
<?php echo $__env->make('acciones_chile.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/acciones_chile/show.blade.php ENDPATH**/ ?>