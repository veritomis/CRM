@extends('usuarios.layout')
@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Creación de Usuario</div>
        <div class="card-body">

            <form action="{{ url('usuarios') }}" id="orden_trabajo_form" method="post">
                {!! csrf_field() !!}
                <label>Usuario</label></br>
                <input type="text" name="usuario" id="usuario" value="{{ old('usuario') }}"
                    class="form-control {{ Session::has('usuario_error') ? 'error' : '' }}" required><br>
                @if (Session::has('usuario_error'))
                    <div style="color: red;">{{ Session::get('usuario_error') }}</div>
                @endif

                <label>Nombre</label></br>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required></br>
                <label>Apellido</label></br>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" class="form-control" required></br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" value="{{ old('email', session('formulario_values.email')) }}"
                    class="form-control {{ Session::has('email_error') ? 'error' : '' }}" required><br>
                @if (Session::has('email_error'))
                    <div style="color: red;">{{ Session::get('email_error') }}</div>
                @endif
                {{-- <label>Password</label></br> --}}
                <input type="hidden" name="password" id="password" class="form-control">
                <script>
                    function generarClave() {
                        var caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                        var longitud = 8;
                        var resultado = '';

                        for (var i = 0; i < longitud; i++) {
                            var indice = Math.floor(Math.random() * caracteresPermitidos.length);
                            resultado += caracteresPermitidos.charAt(indice);
                        }

                        document.getElementById('password').value = resultado;
                    }

                    window.onload = function() {
                        generarClave();
                    };
                </script>
                <label>Cargo</label></br>
                <input type="text" name="cargo" id="cargo" value="{{ old('cargo') }}" class="form-control" required></br>
                <label for="rol">Rol</label><br>
                <select name="rol" id="rol" value="{{ old('rol') }}" class="form-control">
                    @foreach ($roles as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                @endforeach
                </select><br>
                <label for="cotizador">Cotizador:</label>
                <input type="checkbox" name="cotizador" id="cotizador" value="1">
                <br>
                <label for="activo">Activo:</label>
                <input type="checkbox" name="activo" id="activo" value="1">
                <br>
                <div class="d-flex justify-content-end">
                    <a href="{{ url('usuarios') }}" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Guardar" id="submitButton" class="btn btn-success">
                </div>
                <script>
                    // Seleccionar el formulario y el botón de envío
                    const form = document.getElementById('orden_trabajo_form');
                    const submitButton = document.getElementById('submitButton');
                  
                    // Deshabilitar el botón de envío al hacer clic en él
                    //submitButton.addEventListener('click', () => {
                      //submitButton.disabled = true;
                      //form.submit();
                //});
                    
                  </script>
            </form>
        </div>
    </div>
    
@stop
