<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = new Product($validated);
        $product->slug = Str::slug($validated['name'] . '-' . uniqid());
        $product->save();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produkt bol pridaný.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produkt bol upravený.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produkt bol zmazaný.');
    }
}
