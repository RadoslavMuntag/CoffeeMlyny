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

                        <div class="mb-2">
                            <label class="form-label">Street</label>
                            <input type="text" name="street" class="form-control" value="{{ $parts[0] ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $parts[1] ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal" class="form-control" value="{{ $parts[2] ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $parts[3] ?? '' }}">
                        </div>

                        <button type="submit" class="btn btn-black w-100">Save</button>
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
