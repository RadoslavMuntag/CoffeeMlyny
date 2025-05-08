@extends('layouts.app')

@section('content')
    <section class="album py-5">
        <div class="container">
            <div class="row">
                @include('partials.catalogue-filters')
                <main class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Products ({{ $products->total() }})</h5>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
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

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 g-4">
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card border-light p-3">
                                    <a href="{{ route('admin.products.show', $product->slug) }}">
                                        <img src="{{ asset('storage/' . ($product->images->first()->image_path ?? 'default.jpg')) }}"
                                            class="card-img" alt="Product Thumbnail">
                                    </a>
                                    <a class="text-decoration-none text-dark"
                                        href="{{ route('admin.products.show', $product->slug) }}">
                                        <h5 class="mt-3">{{ $product->name }} {{ $product->variant }}</h5>
                                        <p>{{ $product->weight . "g" }}</p>
                                    </a>
                                    <p class="text-muted">{{ $product->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="m-0">€{{ number_format($product->price, 2) }}</h5>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <nav class="mt-4">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </nav>
                </main>
            </div>
        </div>
    </section>
@endsection