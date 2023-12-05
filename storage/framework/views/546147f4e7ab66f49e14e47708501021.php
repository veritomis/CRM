
<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Edición de Usuario</div>
        <div class="card-body">

            <form action="<?php echo e(url('usuarios/' . $usuarios->id)); ?>" id="orden_trabajo_form" method="post">
                <?php echo csrf_field(); ?>

                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="id" id="id" value="<?php echo e($usuarios->id); ?>" id="id" />
                <label>Usuario</label></br>
                <input type="text" name="usuario" id="usuario" value="<?php echo e($usuarios->usuario); ?>"
                class="form-control <?php echo e(Session::has('usuario_error') ? 'error' : ''); ?>" required></br>
                <?php if(Session::has('usuario_error')): ?>
                    <div style="color: red;"><?php echo e(Session::get('usuario_error')); ?></div>
                <?php endif; ?>
                <label>Nombre</label></br>
                <input type="text" name="name" id="name" value="<?php echo e($usuarios->name); ?>"
                    class="form-control" required></br>
                <label>Apellido</label></br>
                <input type="text" name="apellido" id="apellido" value="<?php echo e($usuarios->apellido); ?>"
                    class="form-control" required></br>
                <label>Email</label></br>
                <input type="email" name="email" id="email" value="<?php echo e($usuarios->email); ?>"
                    class="form-control <?php echo e(Session::has('email_error') ? 'error' : ''); ?>" required></br>
                <?php if(Session::has('email_error')): ?>
                    <div style="color: red;"><?php echo e(Session::get('email_error')); ?></div>
                <?php endif; ?>
                <label>Cargo</label></br>
                <input type="text" name="cargo" id="cargo" value="<?php echo e($usuarios->cargo); ?>"
                    class="form-control" required></br>

                <label for="rol">Rol</label><br>
                <select name="rol" id="rol" class="form-control">   
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>" <?php echo e($id == $usuarios->rol ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><br>
                </select><br>
                <label for="cotizador">Cotizador:</label>
                <input type="hidden" name="cotizador" value="0">
                <input type="checkbox" name="cotizador" id="cotizador" value="1" <?php echo e($usuarios->cotizador ? 'checked' : ''); ?>>
                <br>
                <label for="activo">Activo:</label>
                <input type="hidden" name="activo" id="activo" value="0">
                <input type="checkbox" name="activo" id="activo" value="1" <?php echo e($usuarios->activo ? 'checked' : ''); ?>>
                <br>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(url('usuarios')); ?>" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Actualizar" id="submitButton" class="btn btn-success">
                </div>
                <script>
                    // Seleccionar el formulario y el botón de envío
                    const form = document.getElementById('orden_trabajo_form');
                    const submitButton = document.getElementById('submitButton');
                  
                    // Deshabilitar el botón de envío al hacer clic en él
                    submitButton.addEventListener('click', () => {
                      submitButton.disabled = true;
                      form.submit();
                    });
                  </script>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('usuarios.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/usuarios/edit.blade.php ENDPATH**/ ?>