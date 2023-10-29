
<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Creación de Usuario</div>
        <div class="card-body">

            <form action="<?php echo e(url('usuarios')); ?>" id="orden_trabajo_form" method="post">
                <?php echo csrf_field(); ?>

                <label>Usuario</label></br>
                <input type="text" name="usuario" id="usuario" value="<?php echo e(old('usuario')); ?>"
                    class="form-control <?php echo e(Session::has('usuario_error') ? 'error' : ''); ?>" required><br>
                <?php if(Session::has('usuario_error')): ?>
                    <div style="color: red;"><?php echo e(Session::get('usuario_error')); ?></div>
                <?php endif; ?>

                <label>Nombre</label></br>
                <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" class="form-control" required></br>
                <label>Apellido</label></br>
                <input type="text" name="apellido" id="apellido" value="<?php echo e(old('apellido')); ?>" class="form-control" required></br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" value="<?php echo e(old('email', session('formulario_values.email'))); ?>"
                    class="form-control <?php echo e(Session::has('email_error') ? 'error' : ''); ?>" required><br>
                <?php if(Session::has('email_error')): ?>
                    <div style="color: red;"><?php echo e(Session::get('email_error')); ?></div>
                <?php endif; ?>
                
                <input type="hidden" name="password" id="password" class="form-control">
                <script>
                    function generarClave() {
                        var caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                        var longitud = 8;
                        var resultado = '';

                        for (var i = 0; i < longitud; i++) {
                            var indice = Math.floor(Math.random() * caracteresPermitidos.length);
                            resultado += caracteresPermitidos.charAt(indice);
                        }

                        document.getElementById('password').value = resultado;
                    }

                    window.onload = function() {
                        generarClave();
                    };
                </script>
                <label>Cargo</label></br>
                <input type="text" name="cargo" id="cargo" value="<?php echo e(old('cargo')); ?>" class="form-control" required></br>
                <label for="rol">Rol</label><br>
                <select name="rol" id="rol" value="<?php echo e(old('rol')); ?>" class="form-control">
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select><br>
                <label for="cotizador">Cotizador:</label>
                <input type="checkbox" name="cotizador" id="cotizador" value="1">
                <br>
                <label for="activo">Activo:</label>
                <input type="checkbox" name="activo" id="activo" value="1">
                <br>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(url('usuarios')); ?>" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">
                </div>
                <script>
                    // Seleccionar el formulario y el botón de envío
                    const form = document.getElementById('orden_trabajo_form');
                    const submitButton = document.getElementById('submitButton');
                  
                    // Deshabilitar el botón de envío al hacer clic en él
                    //submitButton.addEventListener('click', () => {
                      //submitButton.disabled = true;
                      //form.submit();
                //});
                    
                  </script>
            </form>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('usuarios.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/usuarios/create.blade.php ENDPATH**/ ?>