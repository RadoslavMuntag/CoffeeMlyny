@extends('layouts.app') {{-- hovoríš Laravelu: "toto patrí do app layoutu" --}}

@section('content') {{-- začínaš časť, ktorá sa vloží do @yield('content') --}}
<main>
    <section id="carouselId" class="carousel slide mb-6" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="First slide"></li>
            <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Second slide"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="assets/banners/Banner2.jpg" class="carousel-img-top" alt="Thumbnail">
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>
                            Discover Your Perfect Cup Of Coffee
                        </h1>
                        <p>Expertly roasted beans, crafted with passion, delivered fresh to your door.</p>
                        <p><a class="btn btn-lg btn-warning" href="{{ url('/catalogue') }}">Shop now</a></p>

                    </div>
                </div>

            </div>
            <div class="carousel-item">
                <img src="assets/banners/banner4.jpg" class="carousel-img-top" alt="Thumbnail">
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>
                            Discover Your Perfect Cup Of Coffee
                        </h1>
                        <p>Expertly roasted beans, crafted with passion, delivered fresh to your door.</p>
                        <p><a class="btn btn-lg btn-warning" href="{{ url('/catalogue') }}">Shop now</a></p>

                    </div>
                </div>

            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </section>

    <section class="album py-5 my-5">
        <div class="container">
            <h2 class="text-right mb-4">Coffee Categories</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                <div class="col">
                    <div class="card category-card border-light-subtle position-relative overflow-hidden">
                        <img src="assets/categories/category_singleorigin.jpg" class="card-img" alt="Product Thumbnail">
                        <h5 class="category-text">Single Origin</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card category-card border-light-subtle position-relative overflow-hidden">
                        <img src="assets/categories/category_blends.jpg" class="card-img" alt="Product Thumbnail">
                        <h5 class="category-text">Blends</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card category-card border-light-subtle position-relative overflow-hidden">
                        <img src="assets/categories/category_limited.jpg" class="card-img" alt="Product Thumbnail">
                        <h5 class="category-text">Limited Edition</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card category-card border-light-subtle position-relative overflow-hidden">
                        <img src="assets/categories/category_specials.jpg" class="card-img" alt="Product Thumbnail">
                        <h5 class="category-text">Specials & Decaf</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="album bg-body-tertiary py-5 ">
        <div class="container">
            <h2 class="text-right mb-4">Featured Products</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card border-light p-3">
                        <a href="#">
                            <img src="{{ asset($product->image) }}" class="card-img" alt="Product Thumbnail">
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
    </section>

</main>
@endsection