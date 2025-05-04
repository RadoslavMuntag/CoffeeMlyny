<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleRole(User $user)
    {
        // Protect against locking out self
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return back()->with('success', 'User role updated.');
    }
}
