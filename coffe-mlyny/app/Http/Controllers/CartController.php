<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {

        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $shipping = $subtotal > 50 ? 0 : 5.99;
        $tax = $subtotal * 0.11;
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);

        $cart = session()->get('cart', []);
        $quantityToAdd = $request->quantity ?? 1;

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantityToAdd;

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'You cannot add more than ' . $product->stock . ' items.');
            }

            $cart[$id]['quantity'] = $newQuantity;
        } else {
            if ($quantityToAdd > $product->stock) {
                return back()->with('error', 'Only ' . $product->stock . ' items in stock.');
            }

            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'variant' => $product->variant,
                'slug' => $product->slug,
                'weight' => $product->weight,
                'price' => $product->price,
                'quantity' => $quantityToAdd,
                'image' => $product->images->first()->image_path ?? null,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
    
        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }
    
        $newQuantity = (int) $request->quantity;
    
        if ($newQuantity < 1 || $newQuantity > $cart[$id]['stock']) {
            return redirect()->route('cart.index')->with('error', 'Invalid quantity. Quantity must be between 1 and ' . $cart[$id]['stock']);
        }
    
        $cart[$id]['quantity'] = $newQuantity;
        session()->put('cart', $cart);
    
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }
    


    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
