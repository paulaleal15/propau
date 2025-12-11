@extends('plantilla.admin')

@section('titulo', 'Crear Nueva Habitación')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Crear Nueva Habitación</h1>
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
            <form action="{{ route('habitaciones.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="producto_id">Tipo de Habitación</label>
                    <select name="producto_id" id="producto_id" class="form-control">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}" required>
                </div>
                <div class="form-group">
                    <label for="piso">Piso</label>
                    <input type="text" name="piso" id="piso" class="form-control" value="{{ old('piso') }}" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="disponible">Disponible</option>
                        <option value="ocupada">Ocupada</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
