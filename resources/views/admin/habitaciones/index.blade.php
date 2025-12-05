@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Gestión de Habitaciones</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.habitaciones.create') }}" class="btn btn-primary">Crear Habitación</a>
            <form action="{{ route('admin.habitaciones.index') }}" method="GET" class="d-flex">
                <select name="estado" class="form-control me-2">
                    <option value="">Todos los estados</option>
                    <option value="disponible" {{ request('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="ocupada" {{ request('estado') == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                    <option value="mantenimiento" {{ request('estado') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="limpieza" {{ request('estado') == 'limpieza' ? 'selected' : '' }}>Limpieza</option>
                </select>
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar por número" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
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
                @foreach($habitaciones as $habitacion)
                    <tr>
                        <td>{{ $habitacion->id }}</td>
                        <td>{{ $habitacion->producto->nombre }}</td>
                        <td>{{ $habitacion->numero }}</td>
                        <td>{{ $habitacion->piso }}</td>
                        <td>{{ $habitacion->estado }}</td>
                        <td>
                            <a href="{{ route('admin.habitaciones.edit', $habitacion) }}" class="btn btn-sm btn-primary">Editar</a>
                            @if($habitacion->estado == 'disponible')
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#reservarModal{{ $habitacion->id }}">
                                Reservar
                            </button>
                            @endif
                            <form action="{{ route('admin.habitaciones.destroy', $habitacion) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $habitaciones->links() }}
    </div>

    @foreach($habitaciones as $habitacion)
    <!-- Modal -->
    <div class="modal fade" id="reservarModal{{ $habitacion->id }}" tabindex="-1" aria-labelledby="reservarModalLabel{{ $habitacion->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservarModalLabel{{ $habitacion->id }}">Reservar Habitación: {{ $habitacion->numero }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('carrito.agregarHabitacion') }}" method="POST">
                        @csrf
                        <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
