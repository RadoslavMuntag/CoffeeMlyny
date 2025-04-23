@extends('layouts.app')

@section('content')
    <main>
        <section class="container">
            <form method="POST" action="{{ route('checkout.store') }}">
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
                                        id="payment{{ $method->id }}" value="{{ $method->id }}" required>
                                    <label class="form-check-label" for="payment{{ $method->id }}">
                                        {{ $method->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

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
                            <button class="btn btn-dark w-100 mt-4">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <script>
        document.querySelectorAll('input[name="shipping_method_id"]').forEach(radio => {
            radio.addEventListener('change', function () {
                fetch("{{ route('checkout.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        shipping_method_id: this.value
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Shipping updated:", data);
                        location.reload(); 
                    })
                    .catch(error => {
                        console.error("Error updating shipping:", error);
                    });
            });
        });
    </script>

@endsection