@extends('web.app')

@section('titulo', 'Nuestras Habitaciones')

@section('contenido')
<style>
    .card-disabled {
        opacity: 0.5;
        pointer-events: none;
        position: relative;
    }
    .card-disabled::after {
        content: 'No Disponible';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 1.2rem;
    }
</style>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-1">
        <h2 class="fw-bolder mb-4 text-center">Nuestras Habitaciones</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
            @forelse($productos as $producto)
            <div class="col mb-5">
                <a href="{{ $producto->disponible ? route('web.show', $producto->id) : '#' }}" class="text-decoration-none text-dark">
                    <div class="card h-100 card-hover {{ !$producto->disponible ? 'card-disabled' : '' }}">
                        <!-- Product image-->
                        @if($producto->imagen)
                        <img class="card-img-top" src="{{ asset('uploads/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" />
                        @else
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="Imagen no disponible" />
                        @endif
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{ $producto->nombre }}</h5>
                                <!-- Product description -->
                                <p class="text-muted">{{ $producto->descripcion }}</p>
                                <!-- Product price-->
                                <span class="fw-bold">${{ number_format($producto->precio, 2) }} por noche</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col">
                <p class="text-center">No hay habitaciones disponibles en este momento.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
