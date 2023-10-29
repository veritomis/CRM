<?php
use App\Models\FormDataCle;
?>
@extends('leads_argentina.layout')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
</style>
    <style>
        .body {
            margin-left: 1%;
            margin-right: 2%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <div class="card">

        <div class="card-header">Recotizar Proyecto</div>
        <div class="card-body">
            <div id="camposEdicion" style="">
                <div class="form-group">
                    <form action="{{ route('formulario2.store') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nombre_proyecto">Nombre del Proyecto</label>
                            <input type="text" id="nombre_proyecto" name="nombre_proyecto"
                                value="{{ $proyecto->nombre_proyecto }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="descripcion_proyecto">Descripción del Proyecto</label>
                            <textarea id="descripcion_proyecto" name="descripcion_proyecto" class="form-control">{{ $proyecto->descripcion_proyecto }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_modulos">Cantidad de Módulos</label>
                            <input type="text" id="cantidad_modulos" name="cantidad_modulos"
                                value="{{ $proyecto->cantidad_modulos }}" class="form-control">
                        </div>

                        @if ($proyecto->cantidad_modulos > 1)
                            @for ($i = 1; $i <= $proyecto->cantidad_modulos; $i++)
                                <div class="module-section">
                                    <h3>Módulo {{ $i }}</h3>
                                    <div class="form-group">
                                        <label for="nombre_modulo_{{ $i }}">Nombre del Módulo</label>
                                        <input type="text" name="nombre_modulo_{{ $i }}"
                                            id="nombre_modulo_{{ $i }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcion_modulo_{{ $i }}">Descripción del Módulo</label>
                                        <textarea name="descripcion_modulo_{{ $i }}" id="descripcion_modulo_{{ $i }}"
                                            class="form-control"></textarea>
                                    </div>

                                    @for ($k = 1; $k <= 10; $k++)
                                        <div class="form-group">
                                            <label for="nombre_proceso_{{ $i }}_{{ $k }}">Nombre
                                                Proceso {{ $k }}</label>
                                            <input type="text"
                                                name="nombre_proceso_{{ $i }}_{{ $k }}"
                                                id="nombre_proceso_{{ $i }}_{{ $k }}"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="descripcion_proceso_{{ $i }}_{{ $k }}">Descripción
                                                Proceso {{ $k }}</label>
                                            <textarea name="descripcion_proceso_{{ $i }}_{{ $k }}"
                                                id="descripcion_proceso_{{ $i }}_{{ $k }}" class="form-control"></textarea>
                                        </div>
                                    @endfor
                                </div>
                            @endfor
                        @endif

                        <!-- Botón de envío -->
                        <a href="javascript:history.back()" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
                        <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
                    </form>
                </div>
            </div>
        </div>
