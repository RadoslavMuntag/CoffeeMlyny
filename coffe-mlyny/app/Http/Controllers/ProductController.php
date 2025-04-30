<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;


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

        $products = $products->paginate(9);
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $categories = ProductCategory::all();
        $origins = Product::distinct()->pluck('name');
        $variants = ['Light', 'Medium', 'Dark'];

        return view('catalogue', compact('products', 'categories', 'origins', 'variants', 'minPrice', 'maxPrice'));
    }

    public function show(Product $product)
    {
        $featuredProducts = Product::with('images')->where('featured', true)->take(4)->get();
        return view('product.show', compact('product', 'featuredProducts'));
    }
}
