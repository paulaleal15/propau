@extends('web.app')
@section('container')
<div class="container mx-auto mt-10">
    <div class="shadow-lg p-6 rounded-lg bg-white">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Confirmar y Pagar</h1>

        @if(session('carrito') && count(session('carrito')) > 0)
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Habitación</th>
                            <th class="py-3 px-4 text-left">Check-in</th>
                            <th class="py-3 px-4 text-left">Check-out</th>
                            <th class="py-3 px-4 text-left">Huéspedes</th>
                            <th class="py-3 px-4 text-right">Precio por Noche</th>
                            <th class="py-3 px-4 text-right">Noches</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $carrito = session('carrito');
                        @endphp
                        @foreach($carrito as $id => $details)
                            @php
                                $subtotal = $details['precio'] * $details['cantidad'];
                                $total += $subtotal;
                            @endphp
                            <tr class="border-b">
                                <td class="py-4 px-4 flex items-center">
                                    <img src="{{ asset('uploads/productos/' . $details['imagen']) }}" alt="{{ $details['nombre'] }}" class="h-16 w-16 mr-4 object-cover rounded">
                                    <span class="font-semibold">{{ $details['nombre'] }}</span>
                                </td>
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($details['fecha_inicio'])->format('d/m/Y') }}</td>
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($details['fecha_fin'])->format('d/m/Y') }}</td>
                                <td class="py-4 px-4">{{ $details['huespedes'] }}</td>
                                <td class="py-4 px-4 text-right">S/ {{ number_format($details['precio'], 2) }}</td>
                                <td class="py-4 px-4 text-right">{{ $details['cantidad'] }}</td>
                                <td class="py-4 px-4 text-right">S/ {{ number_format($subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right text-2xl font-bold text-gray-800">
                Total a Pagar: S/ {{ number_format($total, 2) }}
            </div>

            <div class="mt-8 flex justify-end">
                <form action="{{ route('pago.procesar') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Pagar Ahora
                    </button>
                </form>
            </div>
        @else
            <div class="text-center py-10">
                <p class="text-gray-600 text-lg">No hay nada que pagar. Tu carrito está vacío.</p>
                <a href="{{ route('web.habitaciones') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Volver a las habitaciones
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
