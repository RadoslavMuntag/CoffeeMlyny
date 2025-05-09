@extends('layouts.app')

@section('content')

    <main>
        <section class="container py-5">
            <a href="{{ route('admin.products.index') }}" class="btn btn-dark my-2">
                Back
            </a>
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
                    <h4>{{ number_format($product->weight, 2) }}g</h4>

                    <p class="mt-3 text-muted">Current Stock: {{ $product->stock }}</p>
                    <p class="mt-3">{{ $product->description }}</p>

                    <form method="POST" action="{{ route('admin.products.updateStock', $product) }}"
                        class="mt-4 d-flex justify-content-start align-items-center gap-3 w-100">
                        @csrf
                        <div class="d-flex align-items-center border rounded overflow-hidden amount-btn">
                            <input type="number" name="quantity" class="form-control text-center border-0" value="1" min="0"
                                step="1" required>
                        </div>
                        <button type="submit" class="btn btn-success">Update Stock</button>
                    </form>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>

                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete Product</button>
                        </form>
                    </div>

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
                </div>
            </div>
        </section>
    </main>
@endsection