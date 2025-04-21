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

        if ($request->has('variants')) {
            $products->whereIn('variant', $request->get('variants'));
        }

        
        if ($request->has('origins')) {
            $products->whereIn('name', $request->get('origins'));
        }

        
        if ($request->has('price')) {
            $products->where('price', '<=', $request->get('price'));
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
        $variants = ['light', 'medium', 'dark'];

        return view('catalogue', compact('products', 'categories', 'origins', 'variants', 'minPrice', 'maxPrice'));
    }
}