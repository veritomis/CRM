@extends('argentina_cotiza.layout')
@section('content')

    <div class="card">
        <div class="card-header">Edición de Leads Chile</div>
        <div class="card-body">

            <form action="{{ url('argentina_cotiza/' . $argentina_cotiza->id) }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $argentina_cotiza->id }}">

                <label>Telefono</label><br>
                <input type="text" name="work_phone_number" id="work_phone_number" value="{{ $argentina_cotiza->work_phone_number }}"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="work_email" id="work_email" value="{{ $argentina_cotiza->work_email }}" class="form-control"
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
@stop
