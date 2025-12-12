@extends('web.app')
@section('contenido')
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0"
                src="{{asset('uploads/productos/'. $producto->imagen) }}" alt="{{$producto->nombre}}"/></div>
            <div class="col-md-6">
                <div class="small mb-1">SKU: {{$producto->codigo}}</div>
                <h1 class="display-5 fw-bolder">{{$producto->nombre}}</h1>
                <div class="fs-5 mb-5">
                    <span>${{ number_format($producto->precio, 2) }} por noche</span>
                </div>
                <p class="lead">{{$producto->descripcion}}</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('mensaje'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('mensaje') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <form action="{{route('carrito.agregar')}}" method="POST">
                    @csrf
                    <div class="border p-4 rounded-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label fw-bold">LLEGADA</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label fw-bold">SALIDA</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="huespedes" class="form-label fw-bold">HUÉSPEDES</label>
                            <select class="form-select" id="huespedes" name="huespedes" required>
                                @for ($i = 1; $i <= $producto->max_huespedes; $i++)
                                    <option value="{{ $i }}" {{ old('huespedes') == $i ? 'selected' : '' }}>{{ $i }} huésped{{ $i > 1 ? 'es' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <input type="hidden" name="producto_id" value="{{$producto->id}}">
                        <div class="d-grid gap-2">
                                <button class="btn btn-dark btn-lg" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Reservar Ahora
                            </button>
                            <a class="btn btn-outline-secondary" href="{{ route('web.habitaciones') }}">Volver a Habitaciones</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection