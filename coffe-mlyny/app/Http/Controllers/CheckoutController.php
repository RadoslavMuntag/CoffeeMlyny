<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $user = auth()->user();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $shipping = 0;
        $selectedShippingId = session('selected_shipping_id');
        if ($selectedShippingId) {
            $selectedShipping = ShippingMethod::find($selectedShippingId);
            if ($selectedShipping) {
                $shipping = $selectedShipping->price;
            }
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $total * 0.11;
        $total = $tax + $total + $shipping;

        $shippingMethods = ShippingMethod::all();
        $paymentMethods = PaymentMethod::all();


        if ($user != null && $user->address != null) {
            $first_name = $user['first_name'];
            $last_name = $user['last_name'];
            $email = $user['email'];
            $phone = $user['phone'];
            $address = $user['address'];
            $city = $user['city'];
            $postal_code = $user['postal_code'];

            return view('checkout', compact(
                'cart',
                'total',
                'tax',
                'shipping',
                'shippingMethods',
                'paymentMethods',
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'city',
                'postal_code',
                "selectedShippingId"
            ));
        }

        return view('checkout', compact(
            'cart',
            'total',
            'tax',
            'shipping',
            'shippingMethods',
            'paymentMethods',
            "selectedShippingId"
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user_id = $user != null ? $user->id : null;
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^\+?[0-9\s\-]{7,20}$/'],
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => ['required', 'regex:/^[0-9]{3,10}$/'], 
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        
        
        
        
        try {
            if ($validator->fails()) {
                
                throw new ValidationException($validator);
            }
            
            $validated = $validator->validated();

            DB::beginTransaction();

            $shippingMethod = ShippingMethod::findOrFail($validated['shipping_method_id']);
            $shipping = $shippingMethod->price;

            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $tax = $subtotal * 0.11;
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'user_id' => $user_id,
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
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product->decrement('stock', $item['quantity']);

            }

            
            
            Session::forget('cart');
            if ($user != null) {
                try {
                    CartItem::where('user_id', $user->id)
                        ->delete();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            DB::commit();

            return redirect()->route('home')->with('success', 'Order number: ' . $order->id . ' placed successfully.');
        
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty.'], 400);
        }

        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,id',
        ]);

        $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
        $shipping = $shippingMethod->price;

        session(['selected_shipping_id' => $shippingMethod->id]);

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax + $shipping;

        return response()->json([
            'message' => 'Shipping method updated successfully.',
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2)
        ]);
    }

}
