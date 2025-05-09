@extends('layouts.app')

@section('content')
    <main class="container py-5">
        <a href="{{ route('admin.orders') }}" class="btn btn-dark my-2">
            Back
        </a>
        <div class="card p-4 shadow">
            <h2 class="mb-3">Order #{{ $order->id }} Details</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <strong>User:</strong> {{ $order->user->name ?? 'Guest' }}
            </div>
            <div class="mb-3">
                <strong>Status:</strong> {{ ucfirst($order->status) }}
            </div>
            <div class="mb-3">
                <strong>Total (€):</strong> {{ number_format($order->total, 2) }}
            </div>
            <div class="mb-3">
                <strong>Created at:</strong> {{ $order->created_at->format('d.m.Y H:i') }}
            </div>

            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Update Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </main>
@endsection