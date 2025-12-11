@extends('plantilla.admin')

@section('titulo', 'Editar Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Editar Habitación</h1>
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
            <form action="{{ route('habitaciones.update', $habitacion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="producto_id">Tipo de Habitación</label>
                    <select name="producto_id" id="producto_id" class="form-control">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $habitacion->producto_id == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero', $habitacion->numero) }}" required>
                </div>
                <div class="form-group">
                    <label for="piso">Piso</label>
                    <input type="text" name="piso" id="piso" class="form-control" value="{{ old('piso', $habitacion->piso) }}" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="disponible" {{ $habitacion->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="ocupada" {{ $habitacion->estado == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                        <option value="mantenimiento" {{ $habitacion->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>
@endsection
