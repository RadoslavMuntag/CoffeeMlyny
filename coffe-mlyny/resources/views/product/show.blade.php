@extends('layouts.app')

@section('content')

    <main>
        <section class="container py-5">
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            class="card-img-top object-fit-cover product-item rounded-1 shadow-sm" alt="Main Image">
                    </div>

                    <div class="mt-3 d-flex flex-wrap gap-2">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail"
                                style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                onclick="document.getElementById('main-image').src = this.src">
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2>{{ $product->name . " " . $product->variant }}</h2>
                    <h4>€{{ number_format($product->price, 2) }}</h4>

                    <h6 class="mt-3">Select Size</h6>
                    <div class="mt-4 d-flex justify-content-between align-items-center gap-3" role="group">
                        @php
                            $baseSlug = Str::slug($product->name . '-' . $product->variant);
                        @endphp

                        <a href="{{ route('products.show', ['slug' => $baseSlug . '-250']) }}"
                            class="btn btn-product btn-outline-secondary {{ Str::endsWith($product->slug, '25000') ? 'active' : '' }}">250
                            g</a>
                        <a href="{{ route('products.show', ['slug' => $baseSlug . '-500']) }}"
                            class="btn btn-product btn-outline-secondary {{ Str::endsWith($product->slug, '50000') ? 'active' : '' }}">500
                            g</a>
                    </div>

                    @if ($product->stock <= 0)
                        <p class="mt-3 text-danger">Out of stock</p>
                    @else
                        <p class="mt-3 text-muted">Stock: {{ $product->stock }}</p>
                    @endif

                    <form autocomplete="off" method="POST" action="{{ route('cart.add', ['id' => $product->id]) }}"
                        class="mt-4 d-flex justify-content-between align-items-center gap-3 w-100">
                        @csrf
                        <input type="hidden" name="slug" value="{{ $product->slug }}">

                        <div class="d-flex align-items-center border rounded overflow-hidden amount-btn">
                            <input type="number" name="quantity" class="form-control text-center border-0" value="1" min="1"
                                max="{{ $product->stock }}" step="1" required>
                        </div>
                        @if ($product->stock <= 0)
                            <button type="submit" disabled class="btn btn-black">Add to Cart</button>
                        @else
                            <button type="submit" class="btn btn-black">Add to Cart</button>
                        @endif
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="mt-5 text-muted">
                        {{ $product->description }}
                    </p>

                    <div class="d-flex border-top border-light-subtle pt-2 mt-5">
                        <p class="me-3"><i class="bi bi-truck"></i> Free Shipping</p>
                        <p class="me-3"><i class="bi bi-arrow-counterclockwise"></i> 30-Day Returns</p>
                        <p><i class="bi bi-shield"></i> Secure Checkout</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="album bg-body-tertiary py-5 ">
            <div class="container">
                <h2 class="text-right mb-4">You may also like</h2>
                @include('partials.products-featured')
            </div>
        </section>

    </main>
@endsection