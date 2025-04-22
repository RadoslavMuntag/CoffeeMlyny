<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class LandingController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('images')->where('featured', true)->take(4)->get();
        $categories = ProductCategory::all();
    
        return view('landing', compact('featuredProducts', 'categories'));
    }
}
