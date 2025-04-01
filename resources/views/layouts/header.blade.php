<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Bootstrap JS (Include before closing </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .navbar-light {
            background-color: #b3d9ff;
            padding: 0.3rem 0;
        }

        .navbar-brand {
            color: #1565C0;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .container {
            max-width: 98%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .navbar-nav .nav-item {
            margin-right: 0.2rem;
        }

        .d-flex.me-3 {
            margin-right: 0.5rem !important;
        }

        .form-control.me-2 {
            margin-right: 0.3rem !important;
        }

        .btn-sm {
            padding: 0.2rem 0.5rem;
        }

        .dropdown-toggle {
            padding: 0.3rem 0.5rem;
        }

        .btn-outline-light {
            color: #1565C0;
            border-color: #1565C0;
        }

        .btn-outline-light:hover {
            background-color: #1565C0;
            color: #ffffff;
        }

        .btn-outline-success {
            color: #1E88E5;
            border-color: #1E88E5;
        }

        .btn-outline-success:hover {
            background-color: #1E88E5;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-bag-heart"></i> SquishIT
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCart') }}">
                                <i class="bi bi-cart3"></i> Cart
                                <span class="badge bg-warning text-dark">
                                    {{ session()->has('cart') ? count(session()->get('cart')->items) : 0 }}
                                </span>
                            </a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.my') }}">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reviews.index') }}">My Reviews</a>
                        </li>
                        @endauth
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Search Form -->
                        <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                            <input class="form-control me-2" type="search" name="term" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>

                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm mx-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="rounded-circle" width="40" height="40">
                                <span class="ms-2">{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-circle"></i> Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @yield('body')
        </main>
    </div>
</body>

</html>