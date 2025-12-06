@extends('plantilla.admin')

@section('titulo', 'Ver Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Ver Habitación</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $habitacion->producto->nombre }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Número:</strong> {{ $habitacion->numero }}</p>
                    <p><strong>Piso:</strong> {{ $habitacion->piso }}</p>
                    <p><strong>Estado:</strong> {{ $habitacion->estado }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('habitaciones.index') }}" class="btn btn-primary">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
