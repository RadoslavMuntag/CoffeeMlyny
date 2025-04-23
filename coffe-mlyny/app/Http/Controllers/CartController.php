<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function index(Request $request)
    {

        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('cart', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request, $id)
    {
        $user = auth()->user();
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

        if ($user != null) {
            try {
                CartItem::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ],
                    [
                        'quantity' => $cart[$id]['quantity'],
                    ]
                );

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }


        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $user = auth()->user();

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }

        $newQuantity = (int) $request->quantity;

        if ($newQuantity < 1 || $newQuantity > $cart[$id]['stock']) {
            return redirect()->route('cart.index')->with('error', 'Invalid quantity. Quantity must be between 1 and ' . $cart[$id]['stock']);
        }

        $cart[$id]['quantity'] = $newQuantity;
        session()->put('cart', $cart);


        if ($user != null) {
            try {
                CartItem::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $id
                    ],
                    [
                        'quantity' => $newQuantity,
                    ]
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }



    public function remove($id)
    {
        $user = auth()->user();
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        if ($user != null) {
            try {
                CartItem::where('user_id', $user->id)
                    ->where('product_id', $id)
                    ->delete();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
