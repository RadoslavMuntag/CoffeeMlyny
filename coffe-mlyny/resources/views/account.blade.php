@extends('layouts.app')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Welcome, 
                @if(auth()->user()->first_name)
                            {{ auth()->user()->first_name ?? '' }} 
                @else
                {{ auth()->user()->name }}
                @endif
            </h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @auth
                        @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
                            Admin Panel
                        </a>
                        @endif
                    @endauth
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card p-4 shadow-sm">
                        <h5>Account Info</h5>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Address:</strong>
                            @if(auth()->user()->address)
                                {{ auth()->user()->address ?? '' }}, {{ auth()->user()->city ?? '' }}, {{ auth()->user()->postal_code ?? '' }}
                            @else
                                Not set yet
                            @endif
                        </p>
                        <p><strong>Details:</strong>
                            @if(auth()->user()->address)
                                {{ auth()->user()->first_name ?? '' }} {{ auth()->user()->last_name ?? '' }}, {{ auth()->user()->phone ?? '' }}
                            @else
                                Not set yet
                            @endif
                        </p>

                        <form action="{{ route('account.update') }}" method="POST">
                            @csrf
                            @method('PUT')


                            <h5 class="mb-3">Shipping Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name"
                                    value="{{ old('first_name', $first_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                    value="{{ old('last_name', $last_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $email ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone', $phone ?? '') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address', $address ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="City" value="{{ old('city', $city ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal Code"
                                    value="{{ old('postal_code', $postal_code ?? '') }}" required>
                                </div>
                                <button type="submit" class="col-md-6 btn btn-black w-100">Save</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card p-4 shadow-sm">
                    <h5>Order History</h5>

@if($orders->isEmpty())
    <p class="text-muted">No orders yet.</p>
@else
    <ul class="list-group list-group-flush">
        @foreach($orders as $order)
            <li class="list-group-item mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>Order #{{ $order->id }}</strong> <br>
                        <small>Status: {{ ucfirst($order->status) }}</small> <br>
                        <small>Placed on: {{ $order->created_at->format('d M Y') }}</small>
                    </div>
                    <div>
                        <strong>Total:</strong> €{{ number_format($order->total, 2) }}
                    </div>
                </div>
                @if($order->orderItems->count())
                    <ul class="mt-2">
                        @foreach($order->orderItems as $item)
                            <li>
                                {{ $item->product->name ?? 'Deleted Product' }} x{{ $item->quantity }} – €{{ number_format($item->price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection