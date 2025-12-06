@extends('plantilla.admin')

@section('titulo', 'Reservar Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Reservar Habitación: {{ $habitacion->producto->nombre }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('habitaciones.storeBooking', $habitacion->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control">
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="text" name="fecha_fin" id="fecha_fin" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Crear Reserva</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    flatpickr("#fecha_inicio", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    flatpickr("#fecha_fin", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>
@endpush
