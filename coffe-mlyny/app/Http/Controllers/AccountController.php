<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function update(Request $request)
    {
        $request->validate([
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $address = implode('|', [
            $request->input('street'),
            $request->input('city'),
            $request->input('postal'),
            $request->input('country'),
        ]);

        $user = auth()->user();
        $user->address = $address;
        $user->save();

        return redirect()->route('account')->with('success', 'Address updated.');
    }
}
