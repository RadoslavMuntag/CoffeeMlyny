<section class="album py-5 my-5">
    <div class="container">
        <h2 class="text-right mb-4">Coffee Categories</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach ($categories as $category)
                <div class="col">
                    <a href="{{ route('catalogue', ['categories[]' => $category->id]) }}" class="text-decoration-none text-dark">
                        <div class="card category-card border-light-subtle position-relative overflow-hidden">
                            <img src="{{ asset('storage/categories/' . $category->name . '.jpg') }}" class="card-img" alt="{{ $category->name }}">
                            <h5 class="category-text">{{ $category->name }}</h5>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>