@extends('plantilla.admin')

@section('titulo', 'Reservar Habitación')

@section('contenido')
<div class="container">
    <h1>Reservar Habitación: {{ $habitacion->producto->nombre }} (Nº {{ $habitacion->numero }})</h1>

    <div class="card">
        <div class="card-header">
            Detalles de la Reserva
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('habitaciones.storeBooking', $habitacion->id) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="user_id" class="form-label">Cliente</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('user_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }} ({{ $cliente->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha y Hora de Inicio</label>
                            <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" placeholder="Seleccione fecha y hora">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="fecha_fin" class="form-label">Fecha y Hora de Fin</label>
                            <input type="text" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" placeholder="Seleccione fecha y hora">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('habitaciones.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                </div>
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
