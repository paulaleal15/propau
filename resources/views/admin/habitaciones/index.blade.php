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
        <div class="col-12 mb-3">
            <a href="{{ route('habitaciones.create') }}" class="btn btn-primary">Nueva Habitación</a>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Habitación</th>
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
                                <a href="{{ route('habitaciones.show', $habitacion->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('habitaciones.edit', $habitacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('habitaciones.destroy', $habitacion->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta habitación?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $habitaciones->links() }}
        </div>
    </div>
</div>
@endsection
