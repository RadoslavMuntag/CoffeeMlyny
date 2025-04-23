<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $shipping = 0;
        $tax = $total * 0.11;

        $shippingMethods = ShippingMethod::all();
        $paymentMethods = PaymentMethod::all();

        return view('checkout', compact(
            'cart', 'total', 'tax', 'shipping', 'shippingMethods', 'paymentMethods'
        ));
    }

    public function store(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        try {
            DB::beginTransaction();

            $shippingMethod = ShippingMethod::findOrFail($validated['shipping_method_id']);
            $shipping = $shippingMethod->price;

            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $tax = $subtotal * 0.11;
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'user_id' => null,
                'coupon_id' => null,
                'status' => 'pending',
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'shipping_method_id' => $validated['shipping_method_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_price' => $shipping,
                'total' => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            Session::forget('cart');
            DB::commit();

            return redirect()->route('checkout.index')->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process your order. Try again.')->withInput();
        }
    }
}
