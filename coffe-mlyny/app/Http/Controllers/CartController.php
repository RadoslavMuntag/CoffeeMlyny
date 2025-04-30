<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * Display the cart contents
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('cart', compact('cart', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add a product to the cart
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function add(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

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

        // Update database if user is logged in
        $this->syncCartWithDatabase($user, $id, $cart[$id]['quantity']);

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

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

        // Update database if user is logged in
        $this->syncCartWithDatabase($user, $id, $newQuantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function remove(int $id): RedirectResponse
    {
        $user = auth()->user();
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }

        unset($cart[$id]);
        session()->put('cart', $cart);

        // Remove from database if user is logged in
        if ($user) {
            DB::beginTransaction();
            try {
                CartItem::where('user_id', $user->id)
                    ->where('product_id', $id)
                    ->delete();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('cart.index')->with('error', 'Failed to remove item from cart.');
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Sync cart data with database for logged in users
     *
     * @param \App\Models\User|null $user
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    private function syncCartWithDatabase($user, int $productId, int $quantity): void
    {
        if (!$user) {
            return;
        }

        DB::beginTransaction();
        try {
            CartItem::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $productId
                ],
                [
                    'quantity' => $quantity,
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
