@extends('roles.layout')

@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>

    <div class="card">
        <div class="card-header">Visualización de Rol</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Nombre : {{ $roles->nombre }}</h5>
                <p class="card-text">Descripcion : {{ $roles->descripcion }}</p>
                <p class="card-text">Acceso a tabla Usuarios : {{ $roles->usuarios ? 'Si' : 'No' }}</p>
                <p class="card-text">Acceso a tabla Roles : {{ $roles->roles ? 'Si' : 'No' }}</p>
                <p class="card-text">Acceso a tabla Leads : {{ $roles->leads ? 'Si' : 'No' }}</p>
            </div>

            </hr>
            <a href="{{ url('roles') }}" class="btn btn-secondary">Volver</a>

        </div>
    </div>
