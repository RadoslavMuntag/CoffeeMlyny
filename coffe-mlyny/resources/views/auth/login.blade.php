@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-4">
                <div class="card p-4 border-light shadow">
                    <div class="text-center mb-4">
                        <h2>Welcome</h2>
                        <p class="small">Sign in to your account</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                <label class="form-check-label small" for="rememberMe">Remember me</label>
                            </div>
                            <a href="#" class="small text-dark text-decoration-none">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-black w-100">Sign In</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="small text-secondary">Don't have an account? 
                            <a class="text-dark text-decoration-none" href="{{ route('register') }}">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
