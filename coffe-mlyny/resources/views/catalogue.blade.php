@extends('layouts.app')

@section('content')
<section class="album py-5">
    <div class="container">
        <div class="row">
            @include('partials.catalogue-filters')
            <main class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Coffee Beans ({{ $products->total() }})</h5>
                    <form method="GET" action="{{ route('catalogue') }}" class="d-inline">
                        @foreach(request()->except('sort_by') as $name => $value)
                        @if(is_array($value))
                        @foreach($value as $val)
                        <input type="hidden" name="{{ $name }}[]" value="{{ $val }}">
                        @endforeach
                        @else
                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endif
                        @endforeach
                        <select class="form-select w-auto ms-auto" name="sort_by" onchange="this.form.submit()">
                            <option value="">Sort by: Featured</option>
                            <option value="price_low_high" {{ request('sort_by') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high_low" {{ request('sort_by') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>


                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 g-4">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="card border-light p-3">
                            <a href="#">
                                <img src="{{ asset('storage/' . ($product->images->first()->image_path)) }}" class="card-img" alt="Product Thumbnail">
                            </a>
                            <a class="text-decoration-none text-dark" href="#">
                                <h5 class="mt-3">{{ $product->name }}</h5>
                            </a>
                            <p class="text-muted">{{ $product->description }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-0 gap-3">
                                <h5 class="m-0">€{{ number_format($product->price, 2) }}</h5>
                                <button class="btn btn-black">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <nav class="mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </main>
        </div>
    </div>
</section>
@endsection