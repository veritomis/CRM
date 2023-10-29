@extends('usuarios.layout')
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


    <div class="card">
        <div class="card-header">Visualización de Usuario</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Usuario : {{ $usuarios->usuario }}</h5>
                <p class="card-text">Nombre : {{ $usuarios->name }}</p>
                <p class="card-text">Apellido : {{ $usuarios->apellido }}</p>
                <p class="card-text">Email : {{ $usuarios->email }}</p>
                <p class="card-text">Cargo : {{ $usuarios->cargo }}</p>
                <p class="card-text">Rol : {{ $roles[intval($usuarios->rol)] }}</p>
            </div>

            </hr>
            <a href="{{ url('usuarios') }}" class="btn btn-secondary">Volver</a>

        </div>
    </div>
