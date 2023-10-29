@extends('chile_cotiza.layout')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Agregar Detalles de la cotizacion Chile</div>
        <div class="card-body">

            <form action="{{ url('chile_cotiza/' . $chile_cotiza->id) }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $chile_cotiza->id }}">
                <input type="hidden" name="idconsulta" value="{{ $chile_cotiza->idconsulta }}">

                <label>Tiempo de implementaciOn</label><br>
                <input type="text" name="T_implementaciOn" id="T_implementaciOn"
                    value="{{ $chile_cotiza->T_implementaciOn }}" class="form-control" required><br>

                <label>Condiciones</label><br>
                <select name="condiciones" size="5" id="condiciones">
                    <option value="Contado (60%/40%)" <?php if ($chile_cotiza->condiciones === 'Contado (60%/40%)') {
                        echo 'selected';
                    } ?>>Contado (60%/40%)</option>
                    <option value="Financiar en 3 Cuotas" <?php if ($chile_cotiza->condiciones === 'Financiar en 3 Cuotas') {
                        echo 'selected';
                    } ?>>Financiar en 3 Cuotas</option>
                    <option value="Financiar en 3 cuotas + 12 c/tarjeta de crédito" <?php if ($chile_cotiza->condiciones === 'Financiar en 3 cuotas + 12 c/tarjeta de crédito') {
                        echo 'selected';
                    } ?>>Financiar en 3
                        cuotas + 12 c/tarjeta de crédito</option>
                    <option value="12 pagos con Tarjeta de Crédito" <?php if ($chile_cotiza->condiciones === '12 pagos con Tarjeta de Crédito') {
                        echo 'selected';
                    } ?>>12 pagos con Tarjeta de Crédito
                    </option>
                </select><br>


                <label>Testing</label><br>
                <input type="text" name="Testing" id="Testing" value="{{ $chile_cotiza->Testing }}"
                    class="form-control" required><br>

                <label>Costo Total</label><br>
                <input type="text" name="Costo_Total" id="Costo_Total" value="{{ $chile_cotiza->Costo_Total }}"
                    class="form-control" required><br>

                <label>Proyecto</label><br>
                <input type="text" name="nombre_proyecto" id="nombre_proyecto"
                    value="{{ $chile_cotiza->nombre_proyecto }}" class="form-control" required><br>

                <label>Descripcion Proyecto</label><br>
                <input type="text" name="descripcion_proyecto" id="descripcion_proyecto"
                    value="{{ $chile_cotiza->descripcion_proyecto }}" class="form-control" required><br>


                <label>Vence</label><br>
                <input type="date" name="vence" id="vence" value="{{ $chile_cotiza->vence }}" class="form-control"
                    required><br>

                <div class="d-flex justify-content-end">
                    <a href="javascript:history.back()" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>

                    <input type="submit" value="Actualizar" id="submitButton" class="btn btn-success">
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
@stop
