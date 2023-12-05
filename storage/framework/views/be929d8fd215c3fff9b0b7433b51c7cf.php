<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Creación de Rol</div>
        <div class="card-body">
            <form action="<?php echo e(url('roles')); ?>" method="post" id="orden_trabajo_form" onsubmit="return validarFormulario()">
                <?php echo csrf_field(); ?>

                <label>Nombre</label><br>
                <input type="text" name="nombre" id="nombre" value="<?php echo e(old('nombre')); ?>" class="form-control" required><br>
                <label>Descripción</label><br>
                <input type="text" name="descripcion" id="descripcion" value="<?php echo e(old('descripcion')); ?>" class="form-control" required><br>
                <label>Accesos:</label><br>
                <label for="usuarios">Usuarios:</label>
                <input type="checkbox" name="usuarios" id="usuarios" value="1">
                <br>
                <label for="roles">Roles:</label>
                <input type="checkbox" name="roles" id="roles" value="1">
                <br>
                <label for="leads">Leads:</label>
                <input type="checkbox" name="leads" id="leads" value="1">
                <br>
                <label for="leads">Agenda:</label>
                <input type="checkbox" name="agenda" id="agenda" value="1">
                <br>
                <label for="leads">Cotiza:</label>
                <input type="checkbox" name="cotiza" id="cotiza" value="1">
                <br>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(url('roles')); ?>" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>

<script>
    function validarFormulario() {
        var usuariosCheckbox = document.getElementById("usuarios");
        var rolesCheckbox = document.getElementById("roles");
        var leadsCheckbox = document.getElementById("leads");
        var leadsCheckbox = document.getElementById("agenda");
        var leadsCheckbox = document.getElementById("cotiza");

        if (!usuariosCheckbox.checked && !rolesCheckbox.checked && !leadsCheckbox.checked) {
            alert("Debes seleccionar al menos una opción de acceso.");
            return false; // Evita que el formulario se envíe
        }

        return true; // Permite enviar el formulario si al menos una opción está marcada
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('roles.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/roles/create.blade.php ENDPATH**/ ?>