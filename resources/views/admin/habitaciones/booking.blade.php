@extends('plantilla.admin')

@section('titulo', 'Reservar Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Reservar Habitación: {{ $habitacion->producto->nombre }} - N° {{ $habitacion->numero }}</h1>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{ route('habitaciones.storeBooking', $habitacion->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
            </form>
        </div>
    </div>
</div>
@endsection
