<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Visualización de Rol</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Nombre : <?php echo e($roles->nombre); ?></h5>
                <p class="card-text">Descripcion : <?php echo e($roles->descripcion); ?></p>
                <p class="card-text">Acceso a tabla Usuarios : <?php echo e($roles->usuarios ? 'Si' : 'No'); ?></p>
                <p class="card-text">Acceso a tabla Roles : <?php echo e($roles->roles ? 'Si' : 'No'); ?></p>
                <p class="card-text">Acceso a tabla Leads : <?php echo e($roles->leads ? 'Si' : 'No'); ?></p>
                <p class="card-text">Acceso a tabla Leads : <?php echo e($roles->agenda ? 'Si' : 'No'); ?></p>
                <p class="card-text">Acceso a tabla Leads : <?php echo e($roles->cotiza ? 'Si' : 'No'); ?></p>
            </div>

            </hr>
            <a href="<?php echo e(url('roles')); ?>" class="btn btn-secondary">Volver</a>

        </div>
    </div>

<?php echo $__env->make('roles.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/roles/show.blade.php ENDPATH**/ ?>