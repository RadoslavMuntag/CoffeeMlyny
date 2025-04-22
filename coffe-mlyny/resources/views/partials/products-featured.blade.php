<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    @foreach ($featuredProducts as $product)
    <div class="col">
        <div class="card border-light p-3">
            <a href="{{ route('product.show', $product->slug) }}">
                <img
                    src="{{ asset('storage/' . ($product->images->first()->image_path ?? 'default.jpg')) }}"
                    class="card-img"
                    alt="Product Thumbnail">
            </a>
            <a class="text-decoration-none text-dark" href="{{ route('product.show', $product->slug) }}">
                <h5 class="mt-3">{{ $product->name . " " . $product->variant}}</h5>
                <p>{{ $product->weight . "g" }}</p>
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