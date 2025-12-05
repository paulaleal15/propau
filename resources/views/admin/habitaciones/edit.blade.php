@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Editar Habitación</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.habitaciones.update', $habitacion) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="producto_id" class="form-label">Tipo de Habitación</label>
                <select name="producto_id" id="producto_id" class="form-control">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $habitacion->producto_id == $producto->id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero', $habitacion->numero) }}">
            </div>
            <div class="mb-3">
                <label for="piso" class="form-label">Piso</label>
                <input type="text" name="piso" id="piso" class="form-control" value="{{ old('piso', $habitacion->piso) }}">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="disponible" {{ $habitacion->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="ocupada" {{ $habitacion->estado == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                    <option value="mantenimiento" {{ $habitacion->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="limpieza" {{ $habitacion->estado == 'limpieza' ? 'selected' : '' }}>Limpieza</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
@endsection
