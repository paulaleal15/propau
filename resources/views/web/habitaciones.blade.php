@extends('web.app')

@section('titulo', 'Nuestras Habitaciones')

@section('contenido')
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-1">
        <h2 class="fw-bolder mb-4 text-center">Nuestras Habitaciones</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
            @forelse($productos as $producto)
            <div class="col mb-5">
                <div class="card h-100">
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
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $producto->id }}">
                                <button type="submit" class="btn btn-outline-dark mt-auto">Añadir al carrito</button>
                            </form>
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
    </div>
</section>
@endsection
