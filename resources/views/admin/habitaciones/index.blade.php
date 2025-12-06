@extends('plantilla.admin')

@section('titulo', 'Administración de Habitaciones')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Administración de Habitaciones</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{ route('habitaciones.create') }}" class="btn btn-primary">Crear nueva habitación</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Número</th>
                        <th>Piso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($habitaciones as $habitacion)
                        <tr>
                            <td>{{ $habitacion->id }}</td>
                            <td>{{ $habitacion->producto->nombre }}</td>
                            <td>{{ $habitacion->numero }}</td>
                            <td>{{ $habitacion->piso }}</td>
                            <td>{{ $habitacion->estado }}</td>
                            <td>
                                <a href="{{ route('habitaciones.show', $habitacion->id) }}" class="btn btn-info">Ver</a>
                                <a href="{{ route('habitaciones.edit', $habitacion->id) }}" class="btn btn-warning">Editar</a>
                                @if($habitacion->estado == 'disponible')
                                    <a href="{{ route('habitaciones.booking', $habitacion->id) }}" class="btn btn-success">Reservar</a>
                                @else
                                    <a href="#" class="btn btn-success" disabled>Reservar</a>
                                @endif
                                <form action="{{ route('habitaciones.destroy', $habitacion->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
