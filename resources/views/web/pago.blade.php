@extends('web.app')

@section('container')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Confirmar y Pagar</h1>

        @if(session('carrito') && count(session('carrito')) > 0)
            @php
                $total = 0;
                $carrito = session('carrito');
                foreach($carrito as $details) {
                    $total += $details['precio'] * $details['cantidad'];
                }
            @endphp

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Columna Izquierda: Resumen del Pedido -->
                <div class="w-full lg:w-1/2">
                    <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Resumen de la Reserva</h2>
                    <div class="space-y-4">
                        @foreach($carrito as $id => $details)
                            <div class="flex items-center border-b pb-4">
                                <img src="{{ asset('uploads/productos/' . $details['imagen']) }}" alt="{{ $details['nombre'] }}" class="h-20 w-20 object-cover rounded mr-4">
                                <div class="flex-grow">
                                    <p class="font-bold text-lg">{{ $details['nombre'] }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($details['fecha_inicio'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($details['fecha_fin'])->format('d/m/Y') }}
                                        ({{ $details['cantidad'] }} noches)
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $details['huespedes'] }} huéspedes</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">S/ {{ number_format($details['precio'] * $details['cantidad'], 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-right text-2xl font-bold text-gray-800">
                        Total a Pagar: S/ {{ number_format($total, 2) }}
                    </div>
                </div>

                <!-- Columna Derecha: Formulario de Pago -->
                <div class="w-full lg:w-1/2">
                    <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Información de Pago</h2>
                    <form action="{{ route('pago.procesar') }}" method="POST" id="payment-form" class="space-y-4">
                        @csrf

                        <div>
                            <label for="card-holder-name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Titular</label>
                            <input type="text" id="card-holder-name" name="card_holder_name" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nombre completo" required>
                        </div>

                        <div>
                            <label for="card-number" class="block text-sm font-medium text-gray-700 mb-1">Número de Tarjeta</label>
                            <input type="text" id="card-number" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label for="expiry-date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                                <input type="text" id="expiry-date" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="MM/AA" required>
                            </div>
                            <div class="w-1/2">
                                <label for="cvc" class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                <input type="text" id="cvc" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="123" required>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 text-lg">
                                Pagar Ahora (S/ {{ number_format($total, 2) }})
                            </button>
                        </div>
                    </form>
                    <p class="mt-4 text-xs text-center text-gray-500">
                        <strong>Nota:</strong> Este es un formulario de demostración. No se procesará ningún pago real ni se almacenarán los datos de su tarjeta.
                    </p>
                </div>
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
