@extends('acciones_chile.layout')
@section('content')
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>


    <div class="card">
        <div class="card-header">Visualización de Accion</div>
        <div class="card-body">


            <div class="card-body">
                <h5 class="card-title">Nombre: {{ $acciones->accion }}</h5>
                <p class="card-text">Comentario: {{ $acciones->comentario }}</p>

                <p class="card-text">Evidencia 1: 
                    @if ($acciones->documento1)
                    <a href="{{ asset('storage/' . $acciones->documento1) }}" target="_blank" class="btn btn-primary">
                        Ver archivo
                    </a>
                    @endif
                </p>
                <p class="card-text">Evidencia 2: 
                    @if ($acciones->documento2)
                    <a href="{{ asset('storage/' . $acciones->documento2) }}" target="_blank" class="btn btn-primary">
                        Ver archivo
                    </a>
                    @endif
                </p>
                <p class="card-text">Creado por: {{  $usuarios[intval($acciones->usuario)]  }}</p>
                <p class="card-text">Creado el: {{$acciones->created_at}}</p>
            </div>

            </hr>
            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>

        </div>