@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-4">
                <div class="card p-4 border-light shadow">
                    <div class="text-center mb-4">
                        <h2>Create account</h2>
                        <p class="small">Create an account to check out faster</p>
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
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Repeat Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-black w-100">Sign Up</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="small text-secondary">Already have an account? 
                            <a class="text-dark text-decoration-none" href="{{ route('login') }}">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
