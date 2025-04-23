<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;


class LandingController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('images')->where('featured', true)->take(4)->get();
        $categories = ProductCategory::all();
        $user = auth()->user();

        if($user != null){
            Session::forget('cart');
            $cart = Session::get('cart', []);
            $items = CartItem::where('user_id', auth()->id())->get();
            foreach($items as $item){
                $product = Product::find($item->product_id);
                
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'variant' => $product->variant,
                    'slug' => $product->slug,
                    'weight' => $product->weight,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'image' => $product->images->first()->image_path ?? null,
                    'stock' => $product->stock,
                ];
            }
            session()->put('cart', $cart);
        }
    
        return view('landing', compact('featuredProducts', 'categories'));
    }
}
