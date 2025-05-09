<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('images');

        if ($request->filled('search')) {
            $searchTerms = explode(' ', $request->search);

            $products->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('name', 'ILIKE', "%{$term}%")
                            ->orWhere('description', 'ILIKE', "%{$term}%")
                            ->orWhere('variant', 'ILIKE', "%{$term}%")
                            ->orWhereRaw("CAST(weight AS TEXT) ILIKE ?", ["%{$term}%"]);
                    });
                }
            });
        }

        if ($request->has('variants')) {
            $products->whereIn('variant', $request->get('variants'));
        }

        if ($request->has('origins')) {
            $products->whereIn('name', $request->get('origins'));
        }

        if ($request->has('min_price')) {
            $products->where('price', '>=', $request->get('min_price'));
        }

        if ($request->has('max_price')) {
            $products->where('price', '<=', $request->get('max_price'));
        }

        if ($request->has('categories')) {
            $products->whereIn('product_category_id', $request->get('categories'));
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->get('sort_by');
            if ($sortBy == 'price_low_high') {
                $products->orderBy('price', 'asc');
            } elseif ($sortBy == 'price_high_low') {
                $products->orderBy('price', 'desc');
            }
        }

        $products = $products->paginate(12);
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $categories = ProductCategory::all();
        $origins = Product::distinct()->pluck('name');
        $variants = ['Light', 'Medium', 'Dark'];

        return view('admin.products.index', compact(
            'products',
            'categories',
            'origins',
            'variants',
            'minPrice',
            'maxPrice'
        ));
    }


    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'required|in:Light,Medium,Dark',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);
        $slug = Str::slug($request->name . '-' . $request->variant . '-' . $request->weight);



        $product = Product::create([
            'name' => $request->name,
            'variant' => $request->variant,
            'description' => $request->description,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'slug' => $slug,
            'product_category_id' => $request->product_category_id,
        ]);


        if ($request->hasFile('images')) {
            $categorySlug = Str::slug($product->category->name);
            foreach ($request->file('images') as $image) {
                $path = $image->store("products/{$categorySlug}", 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route('admin.products.show', $product->slug)->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->has('images') && count($request->file('images')) == 0 && $product->images->isEmpty()) {
            return back()->with('error', 'Product must have at least one image.');
        }

        // Pridanie validácie pre 'featured'
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'images.*' => 'nullable|image|max:5120',
            'featured' => 'nullable|boolean',
        ]);

        $product->update([
            'name' => $validated['name'],
            'variant' => $validated['variant'] ?? $product->variant,
            'description' => $validated['description'] ?? $product->description,
            'price' => $validated['price'],
            'weight' => $validated['weight'],
            'stock' => $validated['stock'],
            'product_category_id' => $validated['product_category_id'],
            'featured' => $request->has('featured') ? true : false,
        ]);

        if ($request->hasFile('images')) {
            $categoryFolder = Str::slug($product->productCategory->name);
            foreach ($request->file('images') as $image) {
                $path = $image->store("products/{$categoryFolder}", 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.show', $product->slug)->with('success', 'Product updated successfully.');
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function show($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        return view('admin.products.show', compact('product'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->stock = $request->quantity;
        $product->save();

        return back()->with('success', 'Stock updated successfully.');
    }

    public function destroyImage(ProductImage $image)
    {
        $product = $image->product;
        if ($product->images()->count() == 1) {
            return back()->with('error', 'Product must have at least one image.');
        }

        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}


