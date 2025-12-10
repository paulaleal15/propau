@extends('web.app')

@section('titulo', 'Seleccionar Fechas de Reserva')

@section('contenido')
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-1">
        <h2 class="fw-bolder mb-4 text-center">Reservar Habitación: {{ $habitacion->producto->nombre }}</h2>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card mb-5">
                    @if($habitacion->producto->imagen)
                        <img class="card-img-top" src="{{ asset('uploads/productos/' . $habitacion->producto->imagen) }}" alt="{{ $habitacion->producto->nombre }}" />
                    @else
                        <img class="card-img-top" src="https://dummyimage.com/600x400/dee2e6/6c757d.jpg" alt="Imagen no disponible" />
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $habitacion->producto->nombre }}</h5>
                        <p class="card-text">{{ $habitacion->producto->descripcion }}</p>
                        <p class="card-text"><small class="text-muted">Piso: {{ $habitacion->piso }}, Número: {{ $habitacion->numero }}</small></p>
                        <p class="fw-bold fs-5">${{ number_format($habitacion->producto->precio, 2) }} por noche</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Seleccione las fechas de su estancia
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('reservas.verificar') }}" method="POST" id="reservaForm">
                            @csrf
                            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Verificar Disponibilidad y Reservar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');
    const today = new Date().toISOString().split('T')[0];

    fechaInicioInput.setAttribute('min', today);
    fechaFinInput.setAttribute('min', today);

    fechaInicioInput.addEventListener('change', function() {
        if (fechaInicioInput.value) {
            fechaFinInput.setAttribute('min', fechaInicioInput.value);
        }
    });

    document.getElementById('reservaForm').addEventListener('submit', function(event) {
        if (fechaFinInput.value <= fechaInicioInput.value) {
            alert('La fecha de fin debe ser posterior a la fecha de inicio.');
            event.preventDefault();
        }
    });
});
</script>
@endpush
@endsection
