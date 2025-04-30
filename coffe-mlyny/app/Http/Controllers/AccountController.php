<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = Order::with(['orderItems.product'])->where('user_id', $user->id)->latest()->get();

        return view('account', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->shipping_email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->city = $validated['city'];
        $user->postal_code = $validated['postal_code'];
        $user->save();

        return redirect()->route('account')->with('success', 'Address updated.');
    }
}