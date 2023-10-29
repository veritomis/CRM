@extends('leads_argentina.layout')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<link rel="stylesheet" href="app.css" type="text/css">
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Creación de Leads Chile</div>
        <div class="card-body">
            <form action="{{ url('leads_argentina') }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}

                <label>Campaña</label><br>
                <input type="text" name="campaign_name" id="campaign_name" value="{{ old('campaign_name') }}"
                    class="form-control" required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_id" id="form_id" value="{{ old('form_id') }}" class="form-control"
                    required><br>

                <label>Formulario</label><br>
                <input type="text" name="form_name" id="form_name" value="{{ old('form_name') }}" class="form-control"
                    required><br>

                <label>Organización</label><br>
                <input type="text" name="is_organic" id="is_organic" value="{{ old('is_organic') }}" class="form-control"
                    required><br>

                <label>Plataforma</label><br>
                <input type="text" name="platform" id="platform" value="{{ old('platform') }}" class="form-control"
                    required><br>

                <label>Informacion del proyecto</label><br>
                <input type="text" name="cuentanos_mas_sobre_el_proyecto" id="cuentanos_mas_sobre_el_proyecto"
                    value="{{ old('cuentanos_mas_sobre_el_proyecto') }}" class="form-control" required><br>

                <label>Nombre</label><br>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control"
                    required><br>

                <label>Telefono</label><br>
                <input type="text" name="work_phone_number" id="work_phone_number" value="{{ old('work_phone_number') }}"
                    class="form-control" required><br>

                <label>Email</label><br>
                <input type="text" name="work_email" id="work_email" value="{{ old('work_email') }}" class="form-control"
                    required><br>

                <label>Empresa</label><br>
                <input type="text" name="nombre_de_la_empresa" id="nombre_de_la_empresa" value="{{ old('nombre_de_la_empresa') }}"
                    class="form-control" required><br>

                <label>Puesto</label><br>
                <input type="text" name="job_title" id="job_title" value="{{ old('job_title') }}" class="form-control"
                    required><br>

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
@stop
