@extends('plantilla.admin')

@section('titulo', 'Editar Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Editar Habitación</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('habitaciones.update', $habitacion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="producto_id">Producto</label>
                    <select name="producto_id" id="producto_id" class="form-control">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" @if($producto->id == $habitacion->producto_id) selected @endif>{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" value="{{ $habitacion->numero }}">
                </div>
                <div class="form-group">
                    <label for="piso">Piso</label>
                    <input type="text" name="piso" id="piso" class="form-control" value="{{ $habitacion->piso }}">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="disponible" @if($habitacion->estado == 'disponible') selected @endif>Disponible</option>
                        <option value="ocupada" @if($habitacion->estado == 'ocupada') selected @endif>Ocupada</option>
                        <option value="mantenimiento" @if($habitacion->estado == 'mantenimiento') selected @endif>Mantenimiento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Habitación</button>
            </form>
        </div>
    </div>
</div>
@endsection
