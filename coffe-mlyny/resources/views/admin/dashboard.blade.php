@extends('layouts.app')

@section('content')
    <main class="container py-5">
        <div class="card p-4 shadow">
            <h2 class="mb-3">Admin Dashboard</h2>
            <p class="text-muted">Manage your store efficiently</p>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-dark mb-3 p-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-cart"></i> Orders</h5>
                            <p class="card-text">Manage customer orders.</p>
                            <a href="{{ route('admin.orders') }}" class="btn btn-light btn-sm">View Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-dark mb-3 p-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-box"></i> Products</h5>
                            <p class="card-text">Manage your products.</p>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">View Products</a>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-sm">Add Product</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-dark mb-3 p-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-people"></i> Users</h5>
                            <p class="card-text">Manage registered users.</p>
                            <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm">View Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection