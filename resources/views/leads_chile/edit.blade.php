@extends('leads_chile.layout')
@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Edición de Leads Chile</div>
        <div class="card-body">

            <form action="{{ url('leads_chile/' . $leads_chile->id) }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $leads_chile->id }}">

                <!---<label>Campaña</label><br>
                <input type="text" name="campaign_name" id="campaign_name" value="{{ $leads_chile->campaign_name }}"
                    class="form-control" required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_id" id="form_id" value="{{ $leads_chile->form_id }}" class="form-control"
                    required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_name" id="form_name" value="{{ $leads_chile->form_name }}"
                    class="form-control" required><br>

                <label>Organización</label><br>
                <input type="text" name="is_organic" id="is_organic" value="{{ $leads_chile->is_organic }}"
                    class="form-control" required><br>

                <label>Plataforma</label><br>
                <input type="text" name="platform" id="platform" value="{{ $leads_chile->platform }}"
                    class="form-control" required><br>

                <label>Informacion del proyecto</label><br>
                <input type="text" name="cuentanos_sobre_el_proyecto" id="cuentanos_sobre_el_proyecto"
                    value="{{ $leads_chile->cuentanos_sobre_el_proyecto }}" class="form-control" required><br>

                <label>Nombre</label><br>
                <input type="text" name="full_name" id="full_name" value="{{ $leads_chile->full_name }}"
                    class="form-control" required><br>--->

                <label>Telefono</label><br>
                <input type="text" name="phone_number" id="phone_number" value="{{ $leads_chile->phone_number }}"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="email" id="email" value="{{ $leads_chile->email }}" class="form-control"
                    required><br>

                <!---<label>Empresa</label><br>
                <input type="text" name="company_name" id="company_name" value="{{ $leads_chile->company_name }}"
                    class="form-control" required><br>

                <label>Puesto</label><br>
                <input type="text" name="job_title" id="job_title" value="{{ $leads_chile->job_title }}"
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
@stop
