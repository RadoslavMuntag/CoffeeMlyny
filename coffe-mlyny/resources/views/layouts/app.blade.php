<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CoffeeMlyny')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/icons/favicon-96x96.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/icons/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('storage/icons/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/icons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('storage/icons/site.webmanifest') }}">

    <!-- Page specific styles -->
    @yield('styles')
</head>

<body class="d-flex flex-column min-vh-100">

@include('partials.header')

<!-- Flash Messages -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="flex-fill main-content">
    @yield('content')
</div>

@include('partials.footer')

<!-- Core Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" defer></script>

<!-- CSRF Token for AJAX requests -->
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
    };
</script>

<!-- Page specific scripts -->
@yield('scripts')

</body>
</html>
