@extends('layouts.app')

@section('content')
<main class="container my-5">
    <div class="text-center mb-5">
        <h1 class="">About Coffee<b>Mlyny</b></h1>
        <p class="lead">Bringing the world’s finest coffee to your cup since 1995.</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <img src="{{asset('storage/banners/about_us.jpg')}}" class="img-fluid rounded" alt="Coffee Beans">
        </div>
        <div class="col-md-6">
            <h2>Our Story</h2>
            <p>Founded in 1995, CoffeeMlyny was born from a passion for quality coffee. Our journey began with a
                single coffee shop, and today, we source, roast, and deliver the best beans from around the world.
            </p>
            <h2>Our Mission</h2>
            <p>We believe that great coffee should be accessible to everyone. That’s why we are committed to
                sustainability, fair trade, and the art of roasting to bring out the best flavors in every cup.</p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <i class="bi bi-cup-hot fs-1 text-brown"></i>
            <h3>Quality</h3>
            <p>We carefully select the best coffee beans to ensure a rich, flavorful experience.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="bi bi-globe fs-1 text-brown"></i>
            <h3>Sustainability</h3>
            <p>Our coffee is sourced ethically, supporting farmers and eco-friendly practices.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="bi bi-people fs-1 text-brown"></i>
            <h3>Community</h3>
            <p>We build relationships with coffee lovers and growers to create a better coffee culture.</p>
        </div>
    </div>
</main>
@endsection