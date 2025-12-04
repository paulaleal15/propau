@extends('web.app')

@section('titulo', 'Crear Reserva')

@section('contenido')
<div class="container py-5">
    <h2 class="mb-4">Agendar Reserva para la Habitación {{ $habitacion->numero }}</h2>

    <div class="card">
        <div class="card-header">
            Detalles de la Habitación
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $habitacion->producto->nombre }}</h5>
            <p class="card-text">
                <strong>Número:</strong> {{ $habitacion->numero }} <br>
                <strong>Piso:</strong> {{ $habitacion->piso }} <br>
                <strong>Precio por noche:</strong> ${{ number_format($habitacion->producto->precio, 2) }}
            </p>
        </div>
    </div>

    <form action="{{ route('carrito.agregar') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="producto_id" value="{{ $habitacion->producto->id }}">
        <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio (Check-in)</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin (Check-out)</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Añadir al Carrito de Reservas</button>
        <a href="{{ route('web.habitaciones') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
