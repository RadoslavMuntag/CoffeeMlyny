@extends('layouts.app')

@section('content')
<main class="container py-5">
    <div class="card p-4 shadow">
        <h2 class="mb-3">Order #{{ $order->id }} Detail</h2>
        <p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
        <p>User: {{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? 'N/A' }})</p>
        <p>Total: €{{ number_format($order->total, 2) }}</p>
        <p>Created: {{ $order->created_at->format('d.m.Y H:i') }}</p>

        <h4 class="mt-4">Products</h4>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->product->name ?? 'Deleted Product' }} ({{ $item->quantity }}x) — €{{ number_format($item->price, 2) }}</li>
            @endforeach
        </ul>

        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="mt-4">
            @csrf
            @method('PUT')
            <label for="status" class="form-label">Change Status</label>
            <select name="status" id="status" class="form-select w-auto d-inline">
                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                <option value="processing" @selected($order->status === 'processing')>Processing</option>
                <option value="shipped" @selected($order->status === 'shipped')>Shipped</option>
                <option value="completed" @selected($order->status === 'completed')>Completed</option>
            </select>
            <button type="submit" class="btn btn-success ms-2">Update</button>
        </form>
    </div>
</main>
@endsection
