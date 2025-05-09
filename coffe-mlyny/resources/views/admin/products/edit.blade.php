@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <main>
        <section class="container py-5">
            <div class="col-lg-6 mb-4">
                <label class="form-label fw-bold">Current Images</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($product->images as $image)
                        <div class="position-relative" style="width: 100px">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail w-100">
                            <form action="{{ route('admin.products.images.destroy', $image->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')" style="position: absolute; top: 0; right: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 0;">&times;</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <label class="form-label fw-bold">Add More Images</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="form-control">
                        <small class="text-muted">You can upload additional images.</small>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Variant</label>
                                <select name="variant" class="form-select" required>
                                    <option value="Light" {{ $product->variant === 'Light' ? 'selected' : '' }}>Light</option>
                                    <option value="Medium" {{ $product->variant === 'Medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="Dark" {{ $product->variant === 'Dark' ? 'selected' : '' }}>Dark</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="4"
                                    required>{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Price (€)</label>
                                <input type="number" name="price" class="form-control" step="0.01"
                                    value="{{ old('price', $product->price) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Weight</label>
                                <select name="weight" class="form-select" required>
                                    <option value="250" {{ $product->weight == 250 ? 'selected' : '' }}>250</option>
                                    <option value="500" {{ $product->weight == 500 ? 'selected' : '' }}>500</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Stock</label>
                                <input type="number" name="stock" class="form-control"
                                    value="{{ old('stock', $product->stock) }}" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Product Category</label>
                                <select name="product_category_id" class="form-select" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Featured</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="featured" role="switch"
                                        id="featured" value="1" {{ $product->featured ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">
                                        {{ $product->featured ? 'Featured' : 'Not Featured' }}
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-black px-4">Update Product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection