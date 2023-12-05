<?php
use App\Models\FormDataCle;
?>


<?php $__env->startSection('content'); ?>

<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>
    <style>
        .body {
            margin-left: 1%;
            margin-right: 2%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <div class="card">

        <div class="card-header">Guardar Datos</div>
        <div class="card-body">

            <a href="<?php echo e(url('/chile_cotiza/' . $proyecto->id . '/verPDF')); ?>" title="Ver PDF" class="btn btn-info btn-sm"
                style="margin-bottom: 5px;">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <form action="<?php echo e(url('chile_cotiza/' . $proyecto->id . '/updateproyecto')); ?>" method="post"
                id="orden_trabajo_form" onsubmit="return validarFormulario()">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Campos de edición -->
                <div class="form-group">
                    <label for="idconsulta">ID Consulta</label>
                    <input type="text" id="idconsulta" name="idconsulta" value="<?php echo e($proyecto->idconsulta); ?>"
                        class="form-control">
                </div>
                <input type="hidden" id="id" name="id" value="<?php echo e($proyecto->idconsulta); ?>"
                    class="form-control">
                <div class="form-group">
                    <label for="condiciones">Condiciones</label><br>
                    <select name="condiciones" size="5" id="condiciones">
                        <option value="Contado (60%/40%)" <?php if ($proyecto->condiciones == "Contado (60%/40%)") echo "selected"; ?>>Contado (60%/40%)</option>
                        <option value="Financiar en 3 Cuotas" <?php if ($proyecto->condiciones == "Financiar en 3 Cuotas") echo "selected"; ?>>Financiar en 3 Cuotas</option>
                        <option value="Financiar en 3 cuotas + 12 c/tarjeta de crédito" <?php if ($proyecto->condiciones == "Financiar en 3 cuotas + 12 c/tarjeta de crédito") echo "selected"; ?>>Financiar en 3 cuotas + 12 c/tarjeta de crédito</option>
                        <option value="12 pagos con Tarjeta de Crédito" <?php if ($proyecto->condiciones == "12 pagos con Tarjeta de Crédito") echo "selected"; ?>>12 pagos con Tarjeta de Crédito</option>
                    </select><br>
                </div>

                <div class="form-group">
                    <label for="T_implementaciOn">Tiempo de Implementación</label>
                    <input type="text" id="T_implementaciOn" name="T_implementaciOn"
                        value="<?php echo e($proyecto->T_implementaciOn); ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="Testing">Testing</label>
                    <input type="text" id="Testing" name="Testing" value="<?php echo e($proyecto->Testing); ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="Costo_Total">Costo Total</label>
                    <input type="text" id="Costo_Total" name="Costo_Total" value="<?php echo e($proyecto->Costo_Total); ?>"
                        class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="identificador" class="col-sm-2 control-label ewLabel">Cantidad de Gastos Variables:</label>
                    <div class="col-sm-10">
                        <input type="number" data-table="modinspector" data-field="identificador" name="identificador" id="identificador" value="" class="form-control">
                    </div>
                </div>

<button style="margin: 1% 1% 2% 2%;" type="button" onclick="crearGastosVariables()">Crear Gastos Variables</button>

<!-- Contenedor donde se agregarán los campos de gastos variables -->
<div id="camposGastosVariables"></div>

<script>
    function crearGastosVariables() {
        const vueltas = parseInt(document.getElementById("identificador").value);
        let contadorCampos = 0;

		const camposGastosVariables = document.getElementById("camposGastosVariables");
            camposGastosVariables.innerHTML = '';

        for (let index = 1; index <= vueltas; index++) {
            contadorCampos++;

            // Crea un identificador único para este conjunto de campos
            const identificador = "" + contadorCampos;

            // Crea los campos de gastos variables
            const campoNombre = `
                <div class="form-group">
                    <label for="${identificador}_nombre" class="col-sm-2 control-label ewLabel">Nombre:</label>
                    <div class="col-sm-10">
                        <input type="text" data-table="modinspector" data-field="nombre" name="${identificador}_nombre" id="${identificador}_nombre" size="30" maxlength="45" placeholder="Nombre" value="" class="form-control">
                    </div>
                </div>
            `;

            const campoDescripcion = `
                <div class="form-group">
                    <label for="${identificador}_descripcion" class="col-sm-2 control-label ewLabel">Descripción:</label>
                    <div class="col-sm-10">
                        <textarea type="text" data-table="modinspector" data-field="descripcion" name="${identificador}_descripcion" id="${identificador}_descripcion" rows="3" placeholder="Descripción" value="" class="form-control"></textarea>
                    </div>
                </div>
            `;

            const campoMonto = `
                <div class="form-group">
                    <label for="${identificador}_monto" class="col-sm-2 control-label ewLabel">Monto:</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="${identificador}_monto" id="${identificador}_monto" placeholder="Monto" value="" class="form-control">
                    </div>
                </div>

                <br>
            `;

            // Agrega los campos al contenedor
            const camposGastosVariables = document.getElementById("camposGastosVariables");
            camposGastosVariables.innerHTML += campoNombre + campoDescripcion + campoMonto;
        }
    }
</script>
                <!-- Botón de envío --> <a href="javascript:history.back()" class="btn btn-secondary"
                    style="margin-right: 5px;">Volver</a>

                <button type="submit" class="btn btn-primary">Actualizar Datos de la Cotizacion</button>
            </form>
            <!------------------------------>
            <br><br>
            <div id="camposEdicion" style="display: NONE;">
                <div class="form-group">
                    <label for="nombre_proyecto">Nombre del Proyecto</label>
                    <input type="text" id="nombre_proyecto" name="nombre_proyecto"
                        value="<?php echo e($proyecto->nombre_proyecto); ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="descripcion_proyecto">Descripción del Proyecto</label>
                    <textarea id="descripcion_proyecto" name="descripcion_proyecto" class="form-control"><?php echo e($proyecto->descripcion_proyecto); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="cantidad_modulos">Cantidad de Módulos</label>
                    <input type="text" id="cantidad_modulos" name="cantidad_modulos"
                        value="<?php echo e($proyecto->cantidad_modulos); ?>" class="form-control">
                </div>

                <?php if($proyecto->cantidad_modulos > 1): ?>
                    <?php
                        $i = 0;
                        $proyectos = FormDataCle::where('idconsulta', $proyecto['idconsulta'])->get();
                    ?>


                    <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $i += 1;
                            echo '---' . $proyecto['id'];
                            $modulo_campo = 'nombre_modulo';
                            $modulo_descripcion = 'descripcion_modulo';
                        ?>
                        <!----------dddddddddddddddddd------------------actualizarModulo----------->
                        <form action="<?php echo e(url('argentina_cotiza/' . $proyecto->id . '/actualizarModulo')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="module-section">
                                <h3>Módulo <?php echo e($i); ?></h3>
                                <div class="form-group">
                                    <label for="<?php echo e($modulo_campo); ?>">Nombre del Módulo</label>
                                    <input type="text" name="<?php echo e($modulo_campo); ?>" id="<?php echo e($modulo_campo); ?>"
                                        value="<?php echo e($proyecto[$modulo_campo]); ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="<?php echo e($modulo_descripcion); ?>">Descripción del Módulo</label>
                                    <textarea name="<?php echo e($modulo_descripcion); ?>" id="<?php echo e($modulo_descripcion); ?>" class="form-control"><?php echo e($proyecto[$modulo_descripcion]); ?></textarea>
                                </div>

                                <?php for($k = 1; $k <= 10; $k++): ?>
                                    <?php
                                        $proceso_campo = 'nombre_proceso_' . $k;
                                        $proceso_descripcion = 'descripcion_proceso_' . $k;
                                    ?>

                                    <!-- Campos para los procesos -->
                                    <div class="form-group">
                                        <label for="<?php echo e($proceso_campo); ?>">Nombre Proceso <?php echo e($k); ?> -
                                            <?php echo e($i); ?>:</label>
                                        <input type="text" name="<?php echo e($proceso_campo); ?>" id="<?php echo e($proceso_campo); ?>"
                                            value="<?php echo e($proyecto[$proceso_campo]); ?>" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="<?php echo e($proceso_descripcion); ?>">Descripción Proceso
                                            <?php echo e($k); ?> -
                                            <?php echo e($i); ?>:</label>
                                        <textarea name="<?php echo e($proceso_descripcion); ?>" id="<?php echo e($proceso_descripcion); ?>" class="form-control"><?php echo e($proyecto[$proceso_descripcion]); ?></textarea>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <!-- Botón de envío --> <a href="javascript:history.back()" class="btn btn-secondary"
                                style="margin-right: 5px;">Volver</a>
                            <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>

            </form>
            <script>
                document.getElementById('editarProyectoBtn').addEventListener('click', function() {
                    var camposEdicion = document.getElementById('camposEdicion');
                    if (camposEdicion.style.display === 'none') {
                        camposEdicion.style.display = 'block';
                    } else {
                        camposEdicion.style.display = 'none';
                    }
                });
            </script>

        </div>
    </div>

<?php echo $__env->make('leads_argentina.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/chile_cotiza/editProyecto.blade.php ENDPATH**/ ?>