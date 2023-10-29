@extends('chile_cotiza.layout')
@section('content')

    <div class="card">
        <div class="card-header">Edición de Leads Chile</div>
        <div class="card-body">

            <form action="{{ url('chile_cotiza/' . $chile_cotiza->id) }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $chile_cotiza->id }}">

                <label>Telefono</label><br>
                <input type="text" name="phone_number" id="phone_number" value="{{ $chile_cotiza->phone_number }}"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="email" id="email" value="{{ $chile_cotiza->email }}" class="form-control"
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
