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
                <div class="card-body">
                    <h5 class="card-title">Detalles de la Habitación</h5>
                    <p><strong>ID:</strong> {{ $habitacion->id }}</p>
                    <p><strong>Tipo de Habitación:</strong> {{ $habitacion->producto->nombre }}</p>
                    <p><strong>Número:</strong> {{ $habitacion->numero }}</p>
                    <p><strong>Piso:</strong> {{ $habitacion->piso }}</p>
                    <p><strong>Estado:</strong> {{ $habitacion->estado }}</p>
                    <a href="{{ route('habitaciones.index') }}" class="btn btn-primary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
