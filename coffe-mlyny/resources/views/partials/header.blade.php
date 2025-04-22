<header>
    <div class="top-offer text-white text-center py-1">
        <h6>Free shipping on orders over €50! Use code: COFFEE25</h6>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand logo" href="{{ url('/') }}">Coffee<b>Mlyny</b></a>

            <!-- Navbar Toggler (for mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                <!-- Left Navigation Links -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('catalogue') ? 'active' : '' }}" href="{{ url('/catalogue') }}">Catalogue</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a></li>
                </ul>

                <!-- Right Section: Search Bar & Icons -->
                <ul class="navbar-nav align-items-center">
                    <!-- Search Form -->
                    <li class="nav-item">
                        <form class="input-group" action="{{ route('catalogue') }}" method="GET">
                            <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </li>

                    <!-- Icons -->
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link " href="{{ url('/cart') }}"><i class="bi bi-cart3 fs-3"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}"><i class="bi bi-person fs-2"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>