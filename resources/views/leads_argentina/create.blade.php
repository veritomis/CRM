@extends('leads_argentina.layout')
@section('content')

    <style>
        .alert-success {
            background-color: #86B7B5;
            color: white;
        }
    </style>

    <div class="card">
        <div class="card-header">Creación de Leads Argentina</div>
        <div class="card-body">
            <form action="{{ url('leads_argentina') }}" method="post" id="orden_trabajo_form"
                onsubmit="return validarFormulario()">
                {!! csrf_field() !!}

                <br><label>Campaña</label><br>
                <input type="text" name="campaign_name" id="campaign_name" value="{{ old('campaign_name') }}"
                    class="form-control" required>
                <input type="hidden" name="tipificacion" id="tipificacion" value="1" class="form-control">

                @if (Session::has('Campaña_error'))
                    <div class="alert alert-danger">{{ Session::get('Campaña_error') }}</div>
                @endif

                <br><label>ID Formulario</label><br>
                <input type="text" name="form_id" id="form_id" value="{{ old('form_id') }}" class="form-control"
                    required>

                @if (Session::has('ID_error'))
                    <div class="alert alert-danger">{{ Session::get('ID_error') }}</div>
                @endif
                <br><label>Formulario</label><br>
                <input type="text" name="form_name" id="form_name" value="{{ old('form_name') }}" class="form-control"
                    required>

                @if (Session::has('Formulario_error'))
                    <div class="alert alert-danger">{{ Session::get('Formulario_error') }}</div>
                @endif
                <br><label>Organización</label><br>
                <input type="text" name="is_organic" id="is_organic" value="{{ old('is_organic') }}" class="form-control"
                    required>
                @if (Session::has('Organizacion_error'))
                    <div class="alert alert-danger">{{ Session::get('Organizacion_error') }}</div>
                @endif

                <br><label>Plataforma</label><br>
                <input type="text" name="platform" id="platform" value="{{ old('platform') }}" class="form-control"
                    required>

                @if (Session::has('Plataforma_error'))
                    <div class="alert alert-danger">{{ Session::get('Plataforma_error') }}</div>
                @endif

                <br><label>Informacion del proyecto</label><br>
                <input type="text" name="cuentanos_sobre_el_proyecto" id="cuentanos_sobre_el_proyecto"
                    value="{{ old('cuentanos_sobre_el_proyecto') }}" class="form-control" required>

                @if (Session::has('proyecto_error'))
                    <div class="alert alert-danger">{{ Session::get('proyecto_error') }}</div>
                @endif

                <br><label>Nombre</label><br>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control"
                    required>

                @if (Session::has('Nombre_error'))
                    <div class="alert alert-danger">{{ Session::get('Nombre_error') }}</div>
                @endif

                <br><label>Telefono</label><br>
                <input type="text" name="work_phone_number" id="work_phone_number" value="{{ old('work_phone_number') }}"
                    class="form-control" required>

                @if (Session::has('work_email_error'))
                    <div class="alert alert-danger">{{ Session::get('work_email_error') }}</div>
                @endif

                <br><label>Email</label><br>
                <input type="text" name="work_email" id="work_email" value="{{ old('work_email') }}" class="form-control"
                    required>

                @if (Session::has('work_email_error'))
                    <div class="alert alert-danger">{{ Session::get('work_email_error') }}</div>
                @endif

                <br><label>Empresa</label><br>
                <input type="text" name="nombre_de_la_empresa" id="nombre_de_la_empresa" value="{{ old('nombre_de_la_empresa') }}"
                    class="form-control" required>

                @if (Session::has('Empresa_error'))
                    <div class="alert alert-danger">{{ Session::get('Empresa_error') }}</div>
                @endif

                <br><label>Puesto</label><br>
                <input type="text" name="job_title" id="job_title" value="{{ old('job_title') }}" class="form-control"
                    required>

                @if (Session::has('Puesto_error'))
                    <div class="alert alert-danger">{{ Session::get('Puesto_error') }}</div>
                @endif
                <br>
                <div class="d-flex justify-content-end">
                    <a href="{{ url('leads_argentina') }}" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Guardar" id="submitButton" class="btn btn-success"
                        onclick="return validarFormulario();">

                </div>
            </form>
        </div>
    </div>
    <script>
        function validarFormulario() {
            var campaign_name = document.getElementById('campaign_name').value;
            var form_id = document.getElementById('form_id').value;
            var form_name = document.getElementById('form_name').value;
            var is_organic = document.getElementById('is_organic').value;
            var platform = document.getElementById('platform').value;
            var cuentanos_mas_sobre_el_proyecto = document.getElementById('cuentanos_mas_sobre_el_proyecto').value;
            var full_name = document.getElementById('full_name').value;
            var work_phone_number = document.getElementById('work_phone_number').value;
            var work_email = document.getElementById(' work_email').value;
            var nombre_de_la_empresa = document.getElementById('nombre_de_la_empresa').value;
            var job_title = document.getElementById('job_title').value;

            if (
                campaign_name === "" ||
                form_id === "" ||
                form_name === "" ||
                is_organic === "" ||
                platform === "" ||
                cuentanos_mas_sobre_el_proyecto === "" ||
                full_name === "" ||
                work_phone_number === "" ||
                work_email === "" ||
                nombre_de_la_empresa === "" ||
                job_title === ""
            ) {
                //alert("Por favor, complete todos los campos.");
                return false;
            }
            return true;
        }

        // Agrega el evento de escucha al formulario
        document.getElementById('orden_trabajo_form').addEventListener('submit', validarFormulario);
    </script>

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
