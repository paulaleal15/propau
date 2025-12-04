@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Crear Habitación</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.habitaciones.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="producto_id" class="form-label">Tipo de Habitación</label>
                <select name="producto_id" id="producto_id" class="form-control">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}">
            </div>
            <div class="mb-3">
                <label for="piso" class="form-label">Piso</label>
                <input type="text" name="piso" id="piso" class="form-control" value="{{ old('piso') }}">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="limpieza">Limpieza</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
