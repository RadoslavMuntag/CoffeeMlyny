@extends('layouts.app')

@section('content')
    <main>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="card p-4 border-light shadow">
                        <div class="text-center mb-4">
                            <h2>Contact us</h2>
                            <p class="small">We’d love to hear from you! Get in touch with us.</p>
                        </div>
                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-black w-100">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection