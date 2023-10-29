<?php
use App\Models\FormDataCle;
?>
@extends('leads_argentina.layout')

@section('content')

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

            <a href="{{ url('/chile_cotiza/' . $proyecto->id . '/verPDF') }}" title="Ver PDF" class="btn btn-info btn-sm"
                style="margin-bottom: 5px;">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <form action="{{ url('chile_cotiza/' . $proyecto->id . '/updateproyecto') }}" method="post"
                id="orden_trabajo_form" onsubmit="return validarFormulario()">
                @csrf
                @method('PUT')

                <!-- Campos de edición -->
                <div class="form-group">
                    <label for="idconsulta">ID Consulta</label>
                    <input type="text" id="idconsulta" name="idconsulta" value="{{ $proyecto->idconsulta }}"
                        class="form-control">
                </div>
                <input type="hidden" id="id" name="id" value="{{ $proyecto->idconsulta }}"
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
                        value="{{ $proyecto->T_implementaciOn }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="Testing">Testing</label>
                    <input type="text" id="Testing" name="Testing" value="{{ $proyecto->Testing }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="Costo_Total">Costo Total</label>
                    <input type="text" id="Costo_Total" name="Costo_Total" value="{{ $proyecto->Costo_Total }}"
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
                        value="{{ $proyecto->nombre_proyecto }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="descripcion_proyecto">Descripción del Proyecto</label>
                    <textarea id="descripcion_proyecto" name="descripcion_proyecto" class="form-control">{{ $proyecto->descripcion_proyecto }}</textarea>
                </div>

                <div class="form-group">
                    <label for="cantidad_modulos">Cantidad de Módulos</label>
                    <input type="text" id="cantidad_modulos" name="cantidad_modulos"
                        value="{{ $proyecto->cantidad_modulos }}" class="form-control">
                </div>

                @if ($proyecto->cantidad_modulos > 1)
                    @php
                        $i = 0;
                        $proyectos = FormDataCle::where('idconsulta', $proyecto['idconsulta'])->get();
                    @endphp


                    @foreach ($proyectos as $proyecto)
                        @php
                            $i += 1;
                            echo '---' . $proyecto['id'];
                            $modulo_campo = 'nombre_modulo';
                            $modulo_descripcion = 'descripcion_modulo';
                        @endphp
                        <!----------dddddddddddddddddd------------------actualizarModulo----------->
                        <form action="{{ url('argentina_cotiza/' . $proyecto->id . '/actualizarModulo') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="module-section">
                                <h3>Módulo {{ $i }}</h3>
                                <div class="form-group">
                                    <label for="{{ $modulo_campo }}">Nombre del Módulo</label>
                                    <input type="text" name="{{ $modulo_campo }}" id="{{ $modulo_campo }}"
                                        value="{{ $proyecto[$modulo_campo] }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="{{ $modulo_descripcion }}">Descripción del Módulo</label>
                                    <textarea name="{{ $modulo_descripcion }}" id="{{ $modulo_descripcion }}" class="form-control">{{ $proyecto[$modulo_descripcion] }}</textarea>
                                </div>

                                @for ($k = 1; $k <= 10; $k++)
                                    @php
                                        $proceso_campo = 'nombre_proceso_' . $k;
                                        $proceso_descripcion = 'descripcion_proceso_' . $k;
                                    @endphp

                                    <!-- Campos para los procesos -->
                                    <div class="form-group">
                                        <label for="{{ $proceso_campo }}">Nombre Proceso {{ $k }} -
                                            {{ $i }}:</label>
                                        <input type="text" name="{{ $proceso_campo }}" id="{{ $proceso_campo }}"
                                            value="{{ $proyecto[$proceso_campo] }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="{{ $proceso_descripcion }}">Descripción Proceso
                                            {{ $k }} -
                                            {{ $i }}:</label>
                                        <textarea name="{{ $proceso_descripcion }}" id="{{ $proceso_descripcion }}" class="form-control">{{ $proyecto[$proceso_descripcion] }}</textarea>
                                    </div>
                                @endfor
                            </div>
                            <!-- Botón de envío --> <a href="javascript:history.back()" class="btn btn-secondary"
                                style="margin-right: 5px;">Volver</a>
                            <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
                        </form>
                    @endforeach
                @endif
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
