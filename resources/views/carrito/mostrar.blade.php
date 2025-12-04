@extends('web.app')

@section('titulo', 'Detalle de la Reserva')

@section('contenido')
<div class="container py-5">
    <h1 class="mb-4">Detalle de su Reserva</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $carrito = session()->get('carrito', []);
        $total = 0;
    @endphp

    @if(empty($carrito))
        <div class="alert alert-info">
            <p class="mb-0">No tiene ninguna habitación en su reserva.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Habitación</th>
                        <th scope="col">Check-in</th>
                        <th scope="col">Check-out</th>
                        <th scope="col">Precio/Noche</th>
                        <th scope="col">Noches</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrito as $id => $item)
                        @php
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['fecha_inicio'])->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['fecha_fin'])->format('d/m/Y') }}</td>
                            <td>${{ number_format($item['precio'], 0) }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>${{ number_format($subtotal, 0) }}</td>
                            <td>
                                <a href="{{ route('carrito.eliminar', $id) }}" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-4">
            <h4 class="me-4">Total: ${{ number_format($total, 0) }}</h4>
            <form action="{{ route('pedido.realizar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Realizar Reserva</button>
            </form>
            <a href="{{ route('carrito.vaciar') }}" class="btn btn-outline-secondary ms-2">Eliminar Reservas</a>
        </div>
    @endif
</div>
@endsection
