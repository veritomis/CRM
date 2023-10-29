<!-- resources/views/auth/passwords/reset.blade.php -->
@extends('app')

@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
body{
            font-family: 'Work Sans', sans-serif;
    }
</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="app.css" type="text/css">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="{{ asset('storage/foto_sistema/LegalCont-20230603-170641.png')}}" alt="logo" style="max-width: 180px; max-height: 180px; display: block; margin-left: auto; margin-right: auto;">
                    <div class="card-header">{{ __('Restablecer la contraseña') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('reset') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Dirección de correo electrónico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" value="{{ old('email') }}" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input type="hidden" name="password" id="password" class="form-control">
                                    <script>
                                        function generarClave() {
                                            var caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                            var longitud = 9;
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
                                </div>
                            </div>

                        </br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Restablecer la contraseña') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
