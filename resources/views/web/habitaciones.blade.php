@extends('web.app')

@section('titulo', 'Nuestras Habitaciones')

@section('contenido')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Descubre Nuestras Habitaciones</h1>
        <p class="lead">Soluciones de alojamiento de lujo para cada tipo de viajero.</p>
    </div>

    @if($productos->isEmpty())
        <div class="alert alert-info text-center">
            <h4 class="alert-heading">No hay habitaciones disponibles</h4>
            <p>Por favor, inténtelo de nuevo más tarde.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($productos as $producto)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $producto->imagen_url ?? 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success fs-5">${{ number_format($producto->precio, 0) }}/noche</span>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Reservar Ahora</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-5">
            {{ $productos->links() }}
        </div>
    @endif
</div>
@endsection
