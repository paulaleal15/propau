@extends('plantilla.admin')

@section('titulo', 'Nuestras Habitaciones')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bolder mb-4 text-center">Nuestras Habitaciones</h1>
        </div>
    </div>
    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
        @forelse($habitaciones as $habitacion)
        <div class="col mb-5">
            <div class="card h-100">
                <!-- Product image-->
                @if($habitacion->producto->imagen)
                <img class="card-img-top" src="{{ asset('uploads/productos/' . $habitacion->producto->imagen) }}" alt="{{ $habitacion->producto->nombre }}" />
                @else
                <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="Imagen no disponible" />
                @endif
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder">{{ $habitacion->producto->nombre }}</h5>
                        <!-- Room details -->
                        <p class="text-muted">
                            Número: {{ $habitacion->numero }} | Piso: {{ $habitacion->piso }}
                        </p>
                        <!-- Product price-->
                        <span class="fw-bold">${{ number_format($habitacion->producto->precio, 2) }} por noche</span>
                        <!-- Availability -->
                        <p>
                            @if($habitacion->estado == 'disponible')
                                <span class="badge bg-success">Disponible</span>
                            @elseif($habitacion->estado == 'ocupada')
                                <span class="badge bg-danger">Ocupada</span>
                            @else
                                <span class="badge bg-warning">Mantenimiento</span>
                            @endif
                        </p>
                    </div>
                </div>
                <!-- Product actions-->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <a href="{{ route('habitaciones.booking', $habitacion->id) }}" class="btn btn-outline-dark mt-auto {{ $habitacion->estado != 'disponible' ? 'disabled' : '' }}">
                            Reservar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col">
            <p class="text-center">No hay habitaciones disponibles en este momento.</p>
        </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $habitaciones->links() }}
    </div>
</div>
@endsection
