
<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">Edición de Leads Chile</div>
        <div class="card-body">

            <form action="<?php echo e(url('chile_cotiza/' . $chile_cotiza->id)); ?>" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                <?php echo csrf_field(); ?>

                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="id" value="<?php echo e($chile_cotiza->id); ?>">

                <label>Telefono</label><br>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo e($chile_cotiza->phone_number); ?>"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="email" id="email" value="<?php echo e($chile_cotiza->email); ?>" class="form-control"
                    required><br>

                <div class="d-flex justify-content-end">
                    <a href="javascript:history.back()" class="btn btn-secondary" style="margin-right: 1%;">Volver</a> <input type="submit"
                        value="Actualizar" id="submitButton" class="btn btn-success">
                </div>
            </form>

        </div>
    </div>

    <script>
        function validarFormulario() {
            var usuariosCheckbox = document.getElementById("usuarios");
            var rolesCheckbox = document.getElementById("roles");


            if (!usuariosCheckbox.checked && !rolesCheckbox.checked) {
                alert("Debes seleccionar al menos una opción de acceso.");
                return false; // Evita que el formulario se envíe
            }

            return true; // Permite enviar el formulario si al menos una opción está marcada
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('chile_cotiza.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/chile_cotiza/editar.blade.php ENDPATH**/ ?>