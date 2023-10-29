<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: black;
}
</style>

    <div class="card">
        <div class="card-header">Creación de Acción</div>
        <div class="card-body">
            <form action="<?php echo e(url('acciones_argentina')); ?>" method="post" id="orden_trabajo_form" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="ids" id="ids" class="form-control" required>

                <script>
                    // Obtener la URL actual
                    var currentURL = window.location.href;

                    // Obtener el último segmento de la URL que contiene el número
                    var segments = currentURL.split('/');
                    var numero = segments[segments.length - 1];

                    // Asignar el valor del número al campo de entrada
                    document.getElementById("ids").value = numero;
                </script>

                <div class="form-group">
                    <label for="accion">Tipo de Seguimiento</label>
                    <select class="form-control" id="accion" name="accion">
                        <option value="Envío WhatsApp" <?php echo e(old('accion') === 'whatsapp' ? 'selected' : ''); ?>>Envío WhatsApp
                        </option>
                        <option value="Envío Correo" <?php echo e(old('accion') === 'email' ? 'selected' : ''); ?>>Envío Correo</option>
                        <option value="Llamada Telefónica" <?php echo e(old('accion') === 'phone_call' ? 'selected' : ''); ?>>Llamada
                            Telefónica
                        </option>
                        <option value="Reunión" <?php echo e(old('accion') === 'meeting' ? 'selected' : ''); ?>>Reunión</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comentario">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="3"><?php echo e(old('comentario')); ?></textarea>
                </div>



                <label>Evidencia 1</label><br>
                <input type="file" name="documento1" id="documento1" class="form-control"><br>

                <label>Evidencia 2</label><br>
                <input type="file" name="documento2" id="documento2" class="form-control"><br>

                <div class="form-group row" hidden>
                    <label for="usuario" class="col-md-4 col-form-label text-md-right">Usuario</label>
                    <div class="col-md-6">
                        <input id="usuario" type="text" class="form-control" name="usuario"
                            value="<?php echo e(session('ids')); ?>">
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label for="lead" class="col-md-4 col-form-label text-md-right">Lead</label>
                    <div class="col-md-6">
                        <input id="lead" type="text" class="form-control" name="lead"
                            value="<?php echo e($LeadsArgentina); ?>" readonly>
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agregarAgenda" onchange="mostrarFecha()">
                    <label class="form-check-label" for="agregarAgenda">Agregarlo a la agenda</label>
                </div>

                <div class="mt-3" id="fechaAgenda" style="display:none;">
                    <label for="fecha">Fecha para la agenda:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" style="margin-bottom: 5%;width: 15%;">
                </div>

                <script>
                    function mostrarFecha() {
                        var checkbox = document.getElementById("agregarAgenda");
                        var fechaDiv = document.getElementById("fechaAgenda");

                        if (checkbox.checked) {
                            fechaDiv.style.display = "block";
                        } else {
                            fechaDiv.style.display = "none";
                        }
                    }
                </script>

                <div class="d-flex justify-content-end">
                    <a href="javascript:history.back()" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">
                </div>
            </form>
        </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('acciones_argentina.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/acciones_argentina/create.blade.php ENDPATH**/ ?>