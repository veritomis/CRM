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
    @if (session('success'))

    @endif
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/foto_sistema/LegalCont-20230603-170641.png')}}" alt="logo" style="max-width: 180px; max-height: 180px; display: block; margin-left: auto; margin-right: auto;">
                        <h3 class="card-header text-center">Seteo de contraseña</h3>
                        <div class="card-body">
                            <!-- login.blade.php -->

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Dirección de correo electrónico:</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{$email}}" required readonly>
                                </div>
                                

                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <p>Minimo 6 caracteres</p>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar contraseña:</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required></br>
                                    
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
