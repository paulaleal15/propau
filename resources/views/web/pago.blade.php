@extends('web.app')
@section('contenido')

<!-- Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Resumen de la Reserva</h5>
                    </div>
                    <div class="card-body">
                        @if(session('carrito') && count(session('carrito')) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Habitación</th>
                                            <th class="text-center">Detalles</th>
                                            <th class="text-end">Subtotal</th>
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
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('uploads/productos/' . $details['imagen']) }}" alt="{{ $details['nombre'] }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0">{{ $details['nombre'] }}</h6>
                                                            <small class="text-muted d-block">COP {{ number_format($details['precio'], 0, ',', '.') }} / noche</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <small class="d-block"><strong>Llegada:</strong> {{ \Carbon\Carbon::parse($details['fecha_inicio'])->format('d/m/Y') }}</small>
                                                    <small class="d-block"><strong>Salida:</strong> {{ \Carbon\Carbon::parse($details['fecha_fin'])->format('d/m/Y') }}</small>
                                                    <small class="d-block"><strong>Noches:</strong> {{ $details['cantidad'] }}</small>
                                                    <small class="d-block"><strong>Huéspedes:</strong> {{ $details['huespedes'] }}</small>
                                                </td>
                                                <td class="text-end fw-bold">COP {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p>No hay nada que pagar. Tu carrito está vacío.</p>
                                <a href="{{ route('web.habitaciones') }}" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-1"></i> Volver a las habitaciones
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if(session('carrito') && count(session('carrito')) > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Detalles del Pago</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0">Monto Total</h5>
                            <h5 class="mb-0 fw-bold">COP {{ number_format($total, 0, ',', '.') }}</h5>
                        </div>
                        <hr>
                        <!-- Payment Form -->
                        <form action="{{ route('pago.procesar') }}" method="POST" id="payment-form" class="requires-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Método de Pago</label>
                                <div class="bg-light p-2 rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="credit-card" value="credit_card" checked>
                                        <label class="form-check-label" for="credit-card">
                                            <i class="bi bi-credit-card-fill me-1"></i> Tarjeta de Crédito/Débito
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash">
                                        <label class="form-check-label" for="cash">
                                            <i class="bi bi-cash-coin me-1"></i> Efectivo
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="credit-card-form">
                                <div class="mb-3">
                                    <label for="card-name" class="form-label">Nombre en la Tarjeta</label>
                                    <input type="text" class="form-control" id="card-name" placeholder="Juan Pérez" required>
                                    <div class="invalid-feedback">
                                        El nombre en la tarjeta es obligatorio.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="card-number" class="form-label">Número de Tarjeta</label>
                                    <input type="text" class="form-control" id="card-number" placeholder="1111-2222-3333-4444" required>
                                    <div class="invalid-feedback">
                                        El número de tarjeta es obligatorio.
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiration-date" class="form-label">Expiración</label>
                                        <input type="text" class="form-control" id="expiration-date" placeholder="MM/AA" required>
                                        <div class="invalid-feedback">
                                            La fecha de expiración es obligatoria.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="text" class="form-control" id="cvc" placeholder="123" required>
                                        <div class="invalid-feedback">
                                            El CVC es obligatorio.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" id="submit-button" class="btn btn-primary btn-lg">
                                    <i class="bi bi-lock-fill me-1"></i> Pagar Ahora
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardForm = document.getElementById('credit-card-form');
    const creditCardInputs = Array.from(creditCardForm.querySelectorAll('input'));
    const submitButton = document.getElementById('submit-button');

    function validateForm() {
        let isFormValid = true;
        if (document.getElementById('credit-card').checked) {
            isFormValid = creditCardInputs.every(input => input.value.trim() !== '');
        }
        submitButton.disabled = !isFormValid;
    }

    function toggleCreditCardForm() {
        if (document.getElementById('credit-card').checked) {
            creditCardForm.style.display = 'block';
            creditCardInputs.forEach(input => input.required = true);
        } else {
            creditCardForm.style.display = 'none';
            creditCardInputs.forEach(input => input.required = false);
        }
        validateForm();
    }

    paymentMethods.forEach(method => {
        method.addEventListener('change', toggleCreditCardForm);
    });

    creditCardInputs.forEach(input => {
        input.addEventListener('input', validateForm);
    });

    // Initial check
    toggleCreditCardForm();
});
</script>
@endpush
@endsection
