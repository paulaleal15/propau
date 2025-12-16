@extends('web.app')
@section('contenido')
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-12 my-5">
        <h2 class="fw-bold mb-4">Detalle de su reserva</h2>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-5"><strong>Habitación</strong></div>
                            <div class="col-md-2 text-center"><strong>Precio / Noche</strong></div>
                            <div class="col-md-2 text-center"><strong>Noches</strong></div>
                            <div class="col-md-3 text-end"><strong>Subtotal</strong></div>
                        </div>
                    </div>
                    <div class="card-body" id="cartItems">
                        @forelse($carrito as $carritoId => $item)
                        <!-- Product-->
                        <div class="row align-items-center mb-3 cart-item">
                            <!--Nombre y detalles de reserva-->
                            <div class="col-md-5 d-flex align-items-center">
                                <img src="{{ asset('uploads/productos/' . $item['imagen']) }}"
                                style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $item['nombre'] }}">
                                <div class="ms-3">
                                    <h6 class="mb-0">{{ $item['nombre'] }}</h6>
                                    <small class="text-muted d-block">Llegada: {{ \Carbon\Carbon::parse($item['fecha_inicio'])->format('d/m/Y') }}</small>
                                    <small class="text-muted d-block">Salida: {{ \Carbon\Carbon::parse($item['fecha_fin'])->format('d/m/Y') }}</small>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted d-block me-2">Huéspedes:</small>
                                        <form action="{{ route('carrito.actualizarHuespedes') }}" method="POST" class="requires-validation" novalidate>
                                            @csrf
                                            <input type="hidden" name="carrito_id" value="{{ $carritoId }}">
                                            <select name="huespedes" class="form-select form-select-sm" style="width: 80px;" onchange="this.form.submit()">
                                                @for ($i = 1; $i <= ($item['max_huespedes'] ?? 1); $i++)
                                                    <option value="{{ $i }}" {{ $item['huespedes'] == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--Precio-->
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">COP {{ number_format($item['precio'], 0, ',', '.') }}</span>
                            </div>
                            <!--Noches-->
                            <div class="col-md-2 text-center">
                                <span>{{ $item['cantidad'] }}</span>
                            </div>

                            <!--Subtotal-->
                            <div class="col-md-3 d-flex align-items-center justify-content-end">
                                <div class="text-end me-3">
                                    <span class="fw-bold subtotal">COP {{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</span>
                                </div>
                                <a class="btn btn-sm btn-outline-danger" href="{{ route('carrito.eliminar', $carritoId) }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                        </div>
                        <hr>
                        @empty
                        <div class="text-center">
                            <p>No hay Reservas</p>
                        </div>
                        @endforelse
                    </div>
                    @if (session('mensaje'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col text-end">
                                <a class="btn btn-outline-danger me-2" href="{{route('carrito.vaciar')}}">
                                    <i class="bi bi-x-circle me-1"></i>Eliminar Reservas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Resumen de la Reserva</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $total = 0;
                            foreach ($carrito as $item) {
                                $total += $item['precio'] * $item['cantidad'];
                            }
                        @endphp
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="orderTotal">COP {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <!-- Checkout Button -->
                        <a href="{{ route('pago.mostrar') }}" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card me-1"></i>Proceder al Pago
                        </a>
                        <!-- Continue Shopping -->
                        <a href="{{ route('web.habitaciones') }}" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="bi bi-arrow-left me-1"></i>Seguir Reservando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
