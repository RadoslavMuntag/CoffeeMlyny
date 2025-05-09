@extends('layouts.app')

@section('content')
    <main>
        <section class="container py-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark my-2">
                Back
            </a>
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Images</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="form-control" required>
                            <small class="text-muted">You can upload multiple images.</small>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Variant</label>
                            <select name="variant" class="form-select" required>
                                <option value="Light">Light</option>
                                <option value="Medium">Medium</option>
                                <option value="Dark">Dark</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Price (€)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Weight</label>
                            <select name="weight" class="form-select" required>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Category</label>
                            <select name="product_category_id" class="form-select" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-black px-4">Add Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection