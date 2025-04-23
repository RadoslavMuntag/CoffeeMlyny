@extends('layouts.app')

@section('content')
<main>
    <section class="container py-5">
        <h3 class="pb-5">Your Cart ({{ count($cart) }} items)</h3>

        <div class="row">
            <div class="col-md-8">
                @forelse ($cart as $id => $item)
                <div class="card border-light-subtle mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                <img src="{{ asset('storage/' . $item['image']) }}" class=" card-img" alt="Product Thumbnail" style="width: 125px; height: 125px; object-fit: cover;">
                            </a>
                            <div class="ms-3 my-4">
                                <a class="text-decoration-none text-dark" href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                    <h5>{{ $item['name'] . " " . $item['variant'] }}</h5>
                                    <p class="text-muted">{{ $item['weight'] . "g" }}</p>
                                </a>
                                <div class="d-flex align-items-center border rounded overflow-hidden amount-sm-btn">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button class="btn btn-outline-secondary rounded-0 border-0 px-3" type="submit">−</button>
                                    </form>
                                    <form autocomplete="off" action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            name="quantity"
                                            type="number"
                                            min="1"
                                            max="{{ $item['stock'] }}"
                                            value="{{ $item['quantity'] }}"
                                            class="text-center border-0"
                                            style="width: 60px"
                                            onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
                                            onblur="this.form.submit()">
                                    </form>
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button class="btn btn-outline-secondary rounded-0 border-0 px-3" type="submit">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-3 px-3">
                            <h5 class="m-0">€{{ number_format($item['price'] * $item['quantity'], 2) }}</h5>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-dark p-0"><i class="bi bi-trash fs-4"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p>Your cart is empty.</p>
                @endforelse
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card border-light-subtle bg-body-tertiary p-3 mb-3">
                    <div class="order-summary">
                        <h5 class="pb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between">
                            <p>Subtotal</p>
                            <p>€{{ number_format($subtotal, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Tax</p>
                            <p>€{{ number_format($tax, 2) }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Total</p>
                            <p>€{{ number_format($total, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a class="text-decoration-none text-dark w-100" href="{{ route('checkout.index') }}">
                                <button class="btn btn-black btn-checkout">Proceed to Checkout</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection