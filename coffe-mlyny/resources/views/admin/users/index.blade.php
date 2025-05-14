@extends('layouts.app')

@section('content')
    <main class="container py-5">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark my-2">
            Back
        </a>
        <div class="card p-4 shadow">
            <h2 class="mb-3">Users</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                                <td>
                                    <form action="{{ route('admin.users.toggleRole', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="btn btn-sm {{ $user->is_admin ? 'btn-warning' : 'btn-success' }}">
                                            {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </main>
@endsection