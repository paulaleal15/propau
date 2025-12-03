@extends('web.app')

@section('titulo', 'Gestión de Habitaciones')

@section('contenido')
<style>
    .estado-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: .75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    .estado-disponible { background-color: #28a745; }
    .estado-ocupada { background-color: #007bff; }
    .estado-limpieza { background-color: #ffc107; color: #212529; }
    .estado-mantenimiento { background-color: #dc3545; }
    .filter-btn.active {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4">Administra el estado y disponibilidad de las habitaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <form method="GET" action="{{ route('web.habitaciones') }}">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por número o tipo de habitación..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <div class="btn-group">
                    <a href="{{ route('web.habitaciones', ['estado' => 'Todas'] + request()->except('estado')) }}" class="btn btn-outline-secondary filter-btn {{ !request('estado') || request('estado') == 'Todas' ? 'active' : '' }}">
                        Todas ({{ $counts['Todas'] }})
                    </a>
                    <a href="{{ route('web.habitaciones', ['estado' => 'Disponible'] + request()->except('estado')) }}" class="btn btn-outline-secondary filter-btn {{ request('estado') == 'Disponible' ? 'active' : '' }}">
                        Disponibles ({{ $counts['Disponibles'] }})
                    </a>
                    <a href="{{ route('web.habitaciones', ['estado' => 'Ocupada'] + request()->except('estado')) }}" class="btn btn-outline-secondary filter-btn {{ request('estado') == 'Ocupada' ? 'active' : '' }}">
                        Ocupadas ({{ $counts['Ocupadas'] }})
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Room Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @php
            $estados = ['Disponible', 'Ocupada', 'Limpieza', 'Mantenimiento'];
        @endphp
        @forelse($habitaciones as $habitacion)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title"><i class="bi bi-door-open"></i> Hab. {{ $habitacion->numero }}</h5>
                            <div class="dropdown">
                                <button class="btn btn-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><h6 class="dropdown-header">Cambiar estado</h6></li>
                                    @foreach($estados as $estado)
                                        @if($habitacion->estado !== $estado)
                                            <li>
                                                <form action="{{ route('habitaciones.updateStatus', $habitacion) }}" method="POST" class="dropdown-item p-0">
                                                    @csrf
                                                    <input type="hidden" name="estado" value="{{ $estado }}">
                                                    <button type="submit" class="btn btn-link text-decoration-none text-dark w-100 text-start ps-3">{{ $estado }}</button>
                                                </form>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $habitacion->producto->nombre }}</h6>

                        <span class="estado-badge
                            @switch($habitacion->estado)
                                @case('Disponible') estado-disponible @break
                                @case('Ocupada') estado-ocupada @break
                                @case('Limpieza') estado-limpieza @break
                                @case('Mantenimiento') estado-mantenimiento @break
                            @endswitch">
                            {{ $habitacion->estado }}
                        </span>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                        <span>Piso {{ $habitacion->piso }}</span>
                        <span class="fw-bold text-success">${{ number_format($habitacion->producto->precio, 0) }}/noche</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No se encontraron habitaciones que coincidan con los criterios de búsqueda.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
