@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Upraviť produkt</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Názov</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Variant</label>
            <input type="text" name="variant" value="{{ $product->variant }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Cena (€)</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hmotnosť (g)</label>
            <input type="number" name="weight" value="{{ $product->weight }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Popis</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</div>
@endsection
