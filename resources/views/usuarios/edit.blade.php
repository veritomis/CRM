@extends('usuarios.layout')
@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Edición de Usuario</div>
        <div class="card-body">

            <form action="{{ url('usuarios/' . $usuarios->id) }}" id="orden_trabajo_form" method="post">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" id="id" value="{{ $usuarios->id }}" id="id" />
                <label>Usuario</label></br>
                <input type="text" name="usuario" id="usuario" value="{{ $usuarios->usuario }}"
                class="form-control {{ Session::has('usuario_error') ? 'error' : '' }}" required></br>
                @if (Session::has('usuario_error'))
                    <div style="color: red;">{{ Session::get('usuario_error') }}</div>
                @endif
                <label>Nombre</label></br>
                <input type="text" name="name" id="name" value="{{ $usuarios->name }}"
                    class="form-control" required></br>
                <label>Apellido</label></br>
                <input type="text" name="apellido" id="apellido" value="{{ $usuarios->apellido }}"
                    class="form-control" required></br>
                <label>Email</label></br>
                <input type="email" name="email" id="email" value="{{ $usuarios->email }}"
                    class="form-control {{ Session::has('email_error') ? 'error' : '' }}" required></br>
                @if (Session::has('email_error'))
                    <div style="color: red;">{{ Session::get('email_error') }}</div>
                @endif
                <label>Cargo</label></br>
                <input type="text" name="cargo" id="cargo" value="{{ $usuarios->cargo }}"
                    class="form-control" required></br>

                <label for="rol">Rol</label><br>
                <select name="rol" id="rol" class="form-control">   
                    @foreach ($roles as $id => $nombre)
                    <option value="{{ $id }}" {{ $id == $usuarios->rol ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach<br>
                </select><br>
                <label for="cotizador">Cotizador:</label>
                <input type="hidden" name="cotizador" value="0">
                <input type="checkbox" name="cotizador" id="cotizador" value="1" {{ $usuarios->cotizador ? 'checked' : '' }}>
                <br>
                <label for="activo">Activo:</label>
                <input type="hidden" name="activo" id="activo" value="0">
                <input type="checkbox" name="activo" id="activo" value="1" {{ $usuarios->activo ? 'checked' : '' }}>
                <br>
                <div class="d-flex justify-content-end">
                    <a href="{{ url('usuarios') }}" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                    <input type="submit" value="Actualizar" id="submitButton" class="btn btn-success">
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
            </form>
        </div>
    </div>

@stop
