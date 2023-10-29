<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Edición de Leads Argentina</div>
        <div class="card-body">

            <form action="<?php echo e(url('leads_argentina/' . $leads_argentina->id)); ?>" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                <?php echo csrf_field(); ?>

                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="id" value="<?php echo e($leads_argentina->id); ?>">

                <!---<label>Campaña</label><br>
                <input type="text" name="campaign_name" id="campaign_name" value="<?php echo e($leads_argentina->campaign_name); ?>"
                    class="form-control" required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_id" id="form_id" value="<?php echo e($leads_argentina->form_id); ?>" class="form-control"
                    required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_name" id="form_name" value="<?php echo e($leads_argentina->form_name); ?>"
                    class="form-control" required><br>

                <label>Organización</label><br>
                <input type="text" name="is_organic" id="is_organic" value="<?php echo e($leads_argentina->is_organic); ?>"
                    class="form-control" required><br>

                <label>Plataforma</label><br>
                <input type="text" name="platform" id="platform" value="<?php echo e($leads_argentina->platform); ?>"
                    class="form-control" required><br>

                <label>Informacion del proyecto</label><br>
                <input type="text" name="cuentanos_sobre_el_proyecto" id="cuentanos_sobre_el_proyecto"
                    value="<?php echo e($leads_argentina->cuentanos_sobre_el_proyecto); ?>" class="form-control" required><br>

                <label>Nombre</label><br>
                <input type="text" name="full_name" id="full_name" value="<?php echo e($leads_argentina->full_name); ?>"
                    class="form-control" required><br>--->

                <label>Telefono</label><br>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo e($leads_argentina->phone_number); ?>"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="email" id="email" value="<?php echo e($leads_argentina->email); ?>" class="form-control"
                    required><br>

                <!---<label>Empresa</label><br>
                <input type="text" name="company_name" id="company_name" value="<?php echo e($leads_argentina->company_name); ?>"
                    class="form-control" required><br>

                <label>Puesto</label><br>
                <input type="text" name="job_title" id="job_title" value="<?php echo e($leads_argentina->job_title); ?>"
                    class="form-control" required>---><br>
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

<?php echo $__env->make('leads_argentina.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/leads_argentina/edit.blade.php ENDPATH**/ ?>