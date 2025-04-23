@extends('layouts.app')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome, {{ auth()->user()->name }}</h2>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
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
                                                    @php
                                                        $parts = explode('|', auth()->user()->address);
                                                    @endphp
                                                    {{ $parts[0] ?? '' }}, {{ $parts[1] ?? '' }}, {{ $parts[2] ?? '' }}, {{ $parts[3] ?? '' }}
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
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" name="phone" placeholder="Phone" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="address" placeholder="Address" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" placeholder="City" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal Code"
                                        required>
                                </div>
                                <button type="submit" class="col-md-6 btn btn-black w-100">Save</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card p-4 shadow-sm">
                        <h5>Order History</h5>
                        <p class="text-muted">No orders yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection