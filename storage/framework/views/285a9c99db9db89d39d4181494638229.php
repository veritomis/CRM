
<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
body{
            font-family: 'Work Sans', sans-serif;
        }
</style>


    <div class="card">
        <div class="card-header">Visualización de Usuario</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Usuario : <?php echo e($usuarios->usuario); ?></h5>
                <p class="card-text">Nombre : <?php echo e($usuarios->name); ?></p>
                <p class="card-text">Apellido : <?php echo e($usuarios->apellido); ?></p>
                <p class="card-text">Email : <?php echo e($usuarios->email); ?></p>
                <p class="card-text">Cargo : <?php echo e($usuarios->cargo); ?></p>
                <p class="card-text">Rol : <?php echo e($roles[intval($usuarios->rol)]); ?></p>
            </div>

            </hr>
            <a href="<?php echo e(url('usuarios')); ?>" class="btn btn-secondary">Volver</a>

        </div>
    </div>

<?php echo $__env->make('usuarios.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/usuarios/show.blade.php ENDPATH**/ ?>