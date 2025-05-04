@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Pridať nový produkt</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Názov</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Variant</label>
            <input type="text" name="variant" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Cena (€)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hmotnosť (g)</label>
            <input type="number" name="weight" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Popis</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Obrázok</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Uložiť</button>
    </form>
</div>
@endsection
