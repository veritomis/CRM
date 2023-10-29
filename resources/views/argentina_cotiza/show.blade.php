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

    <div class="card">
        <div class="row mb-3">
            <div class="col-md-4 text-center">
                <a href="{{ url('/acciones_chile/create', ['LeadsChile' => $leads_argentina->id]) }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        <div class="card-header">Visualización de Leads Chile</div>
        <div class="card-body">
            <h5>Nombre de Campaña: {{ $leads_argentina->campaign_name }}</h5>
        
            <table class="table table-bordered" style="text-align: center;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Organizacion</th>
                        <th>Plataforma</th>
                        <th>Proyecto</th>
                        <th>Nombre Cliente</th>
                        <th>Celular</th>
                        <th>email</th>
                        <th>Empresa</th>
                        <th>Cargo</th>
                        <!-- Agrega más encabezados de columna aquí -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $leads_argentina->form_id }}</td>
                        <td>{{ $leads_argentina->form_name }}</td>
                        <td>{{ $leads_argentina->is_organic }}</td>
                        <td>{{ $leads_argentina->platform }}</td>
                        <td>{{ $leads_argentina->cuentanos_mas_sobre_el_proyecto }}</td>
                        <td>{{ $leads_argentina->full_name }}</td>
                        <td>{{ $leads_argentina->work_phone_number }}</td>
                        <td>{{ $leads_argentina->work_email }}</td>
                        <td>{{ $leads_argentina->nombre_de_la_empresa }}</td>
                        <td>{{ $leads_argentina->job_title }}</td>
                        <!-- Agrega más celdas de datos aquí para cada columna -->
                    </tr>
                </tbody>
            </table>
        
            <a href="javascript:history.back()" class="btn btn-secondary" style="margin-right: 5px;">Volver</a>
        </div>
        
        <div class="card-body">
            <h5 style="margin-bottom: 0px padding-bottom: 0px;">Visualización de Acciones</h5></br>
            <table class="custom-table" style="text-align: center;">
                <thead style="background-color: #007BFF;">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Comentario</th>
                        <th>Evidencia 1</th>
                        <th>Evidencia 2</th>
                        <th>Creado por</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($acciones_argentina as $accion)
                        <tr>
                            <td>{{ $accion->accion }}</td>
                            <td>{{ $accion->descripcion }}</td>
                            <td>{{ $accion->comentario }}</td>
                            <td>
                                @if ($accion->documento1)
                                    <a href="{{ asset('storage/' . $accion->documento1) }}" target="_blank"
                                        class="btn btn-primary">
                                        Ver archivo
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($accion->documento2)
                                    <a href="{{ asset('storage/' . $accion->documento2) }}" target="_blank"
                                        class="btn btn-primary">
                                        Ver archivo
                                    </a>
                                @endif
                            </td>
                            <td>{{ $usuarios[intval($accion->usuario)] }}</td>
                            <td>{{ $accion->created_at }}</td>
                            <td>
                                <a href="{{ url('/acciones_argentina/' . $accion->id) }}" title="View acciones"
                                    class="btn btn-info btn-sm"><i class="fas fa-envelope" aria-hidden="true"></i>
                                    Vista</a>
                                {{-- <a href="{{ url('/acciones/' . $accion->id . '/edit') }}"
                                    title="Editar acciones" class="btn btn-primary btn-sm"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
