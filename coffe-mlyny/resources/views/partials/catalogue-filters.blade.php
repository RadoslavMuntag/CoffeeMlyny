<aside class="col-md-3">
    <h5>Filters</h5>
    <form method="GET" action="{{ route('catalogue') }}">
        <!-- Roast Level -->
        <div class="mb-3">
            <label class="form-label fw-bold">Roast Level</label>
            @foreach ($variants as $variant)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="variants[]"
                           value="{{ $variant }}"
                           id="variant_{{ $loop->index }}"
                           {{ in_array($variant, request()->get('variants', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="variant_{{ $loop->index }}">
                        {{ ucfirst($variant) }}
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Origin -->
        <div class="mb-3">
            <label class="form-label fw-bold">Origin</label>
            @foreach ($origins as $origin)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="origins[]"
                           value="{{ $origin }}"
                           id="origin_{{ $origin }}"
                           {{ in_array($origin, request()->get('origins', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="origin_{{ $origin }}">
                        {{ ucfirst($origin) }}
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label class="form-label fw-bold">Category</label>
            @foreach ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="categories[]"
                           value="{{ $category->id }}"
                           id="category_{{ $category->id }}"
                           {{ in_array($category->id, request()->get('categories', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Price Range -->
        <div class="mb-3">
            <label for="priceRange" class="form-label fw-bold">Price Range</label>
            <div class="d-flex justify-content-between">
                <span>€{{ $minPrice }}</span>
                <input type="range" class="form-range" name="price" id="priceRange" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ request()->get('price', $maxPrice) }}">
                <span>€{{ $maxPrice }}</span>
            </div>
        </div>


        <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
    </form>
</aside>
