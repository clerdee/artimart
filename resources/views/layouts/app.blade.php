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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Bootstrap JS (Include before closing </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #e65100;
            --primary-color-hover: #d84315;
            --light-bg: #fff3e0;
            --gradient-start: #ffecb3;
            --gradient-end: #fff8e1;
        }

        body {
            font-family: 'Nunito', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            padding: 0.5rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand:hover {
            color: var(--primary-color-hover);
        }

        .container {
            max-width: 98%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .nav-link {
            color: #555;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .btn-nav {
            color: #fff;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-nav:hover {
            background-color: var(--primary-color-hover);
            border-color: var(--primary-color-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-nav {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-outline-nav:hover {
            background-color: var(--primary-color);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0.3rem 0;
        }

        .badge {
            border-radius: 50px;
            padding: 0.35em 0.65em;
        }

        .badge-warning {
            background-color: var(--primary-color);
            color: white;
        }

        /* Animation for elements */
        .animated-element {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .animated-element:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Profile image styling */
        .profile-image {
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="fas fa-palette"></i> ArtiMart
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link animated-element" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link animated-element" href="{{ route('getCart') }}">
                                <i class="fas fa-shopping-cart me-1"></i> Shopping Cart
                                <span class="badge badge-warning">
                                    {{ session()->has('cart') ? count(session()->get('cart')->items) : 0 }}
                                </span>
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link btn-outline-nav mx-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>{{ __('Login') }}
                            </a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link btn-nav" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>{{ __('Register') }}
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="rounded-circle profile-image" width="40" height="40">
                                <span class="ms-2">{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-circle me-2"></i> Profile
                                </a>
                                @if (Auth::user()->role === 'Admin')
                                <a class="dropdown-item" href="{{ route('admin.orders') }}">
                                    <i class="fas fa-clipboard-list me-2"></i> Orders
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.users') }}">
                                    <i class="fas fa-users me-2"></i> Users
                                </a>
                                <hr class="dropdown-divider">
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
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
        </main>
    </div>
</body>

</html>