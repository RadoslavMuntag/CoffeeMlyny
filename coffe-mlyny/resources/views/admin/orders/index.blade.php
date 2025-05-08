@extends('layouts.app')

@section('content')
    <main class="container py-5">
        <div class="card p-4 shadow">
            <h2 class="mb-3">Orders</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Total (€)</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
@endsection