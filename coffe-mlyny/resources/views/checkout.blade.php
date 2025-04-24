@extends('layouts.app')

@section('content')
    <main>
        <section class="container">
            <form method="POST" id="checkout-form" action="{{ route('checkout.store') }}">
                @csrf
                <div class="row py-5">
                    <div class="col-lg-8">
                        <div class="p-4 border rounded mb-4">
                            <h5 class="mb-3">Shipping Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name"
                                        value="{{ old('first_name', $first_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                        value="{{ old('last_name', $last_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        value="{{ old('email', $email ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" name="phone" placeholder="Phone"
                                        value="{{ old('phone', $phone ?? '') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="address" placeholder="Address"
                                        value="{{ old('address', $address ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="City"
                                        value="{{ old('city', $city ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal Code"
                                        value="{{ old('postal_code', $postal_code ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded mb-4">
                            <h5 class="mb-3">Payment Method</h5>
                            @foreach ($paymentMethods as $method)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method_id"
                                        id="payment{{ $method->id }}" value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="payment{{ $method->id }}">
                                        {{ $method->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>


                        <div class="p-4 border rounded mb-4">
                            <div id="shipping-methods">
                                @foreach ($shippingMethods as $method)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="shipping_method_id"
                                            id="shipping{{ $method->id }}" value="{{ $method->id }}" {{ $selectedShippingId == $method->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="shipping{{ $method->id }}">
                                            {{ $method->name }} (€{{ number_format($method->price, 2) }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-4">
                        <div class="p-4 border rounded">
                            <h5 class="mb-3">Order Summary</h5>
                            @foreach ($cart as $item)
                                <div class="card mb-3">
                                    <div class="d-flex align-items-center">
                                        @if (isset($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="cart-img me-2"
                                                style="width: 60px; height: auto;" alt="Product">
                                        @endif
                                        <div>
                                            <p class="mb-0">{{ $item['name'] }}</p>
                                            <small>{{ $item['quantity'] }} × €{{ number_format($item['price'], 2) }}</small>
                                        </div>
                                        <span
                                            class="ms-auto fw-bold me-2">€{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Tax</span>
                                <span class="fw-bold">€{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Shipping</span>
                                <span class="fw-bold">€{{ number_format($shipping, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>€{{ number_format($total, 2) }}</strong>
                            </div>
                            <input type="text" class="form-control my-3" placeholder="Promo Code (coming soon 🔒)" disabled>
                            <button type="button" class="btn btn-dark w-100 mt-4" onclick="handlePlaceOrderClick()">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Pay Confirmation Modal -->
            <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="payModalLabel">Confirm Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            You're about to place your order. Do you want to continue?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark" form="checkout-form">Pay</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
    <script>
    const shippingRadios = document.querySelectorAll('input[name="shipping_method_id"]');
    const shippingDisplay = document.querySelectorAll('.d-flex.justify-content-between span.fw-bold')[1]; // Shipping
    const totalDisplay = document.querySelectorAll('.d-flex.justify-content-between strong')[1]; // Total

    const baseTotalWithoutShipping = {{ $total - $shipping }};
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'EUR'
    });

    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedLabel = this.nextElementSibling.textContent;
            const selectedShippingPrice = parseFloat(selectedLabel.match(/€([\d.,]+)/)[1].replace(',', ''));

            shippingDisplay.textContent = formatter.format(selectedShippingPrice);
            totalDisplay.textContent = formatter.format(baseTotalWithoutShipping + selectedShippingPrice);
        });
    });

    function handlePlaceOrderClick() {
        const selectedPayment = document.querySelector('input[name="payment_method_id"]:checked');

        if (!selectedPayment) {
            alert("Please select a payment method.");
            return;
        }

        const cardPaymentId = "1";

        if (selectedPayment.value === cardPaymentId) {
            const payModal = new bootstrap.Modal(document.getElementById('payModal'));
            payModal.show();
        } else {
            document.getElementById('checkout-form').submit();
        }
    }
</script>
@endsection