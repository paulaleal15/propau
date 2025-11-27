
@extends('web.app')
@section('header')
@endsection
@section('contenido')
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-1">
        <h2 class="fw-bolder mb-4">Nuestras Habitaciones</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center">
            @foreach($productos as $producto)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="{{asset('uploads/productos/'. $producto->imagen) }}"
                        alt="{{$producto->nombre}}" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{$producto->nombre}}</h5>
                            <!-- Product description-->
                            <p class="text-muted">{{$producto->descripcion}}</p>
                            <!-- Product price-->
                            $ {{number_format($producto->precio, 2)}}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                href="{{route('web.show', $producto->id)}}">Ver
                                detalles</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer clearfix">
            {{ $productos->links() }}
        </div>
    </div>
</section>
@endsection
