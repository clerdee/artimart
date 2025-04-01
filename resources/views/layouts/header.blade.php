<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'ArtiMart') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #6c757d;
            --accent-color: #ff9e00;
            --light-bg: #f8f9fa;
            --navbar-bg: #ffffff;
            --text-color: #212529;
            --border-radius: 0.5rem;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
        }
        
        .navbar {
            background-color: var(--navbar-bg);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 0;
        }
        
        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
        }
        
        .navbar-brand i {
            color: var(--accent-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-color);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link:focus {
            color: var(--primary-color);
        }
        
        .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
        }
        
        .dropdown-menu {
            border-radius: var(--border-radius);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .search-form {
            position: relative;
        }
        
        .search-form .form-control {
            padding-left: 2.5rem;
            border-radius: 2rem;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
        }
        
        .search-form .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        .badge-cart {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(25%, -25%);
        }
        
        .profile-dropdown-toggle {
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .profile-img {
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .profile-dropdown-toggle:hover .profile-img {
            border-color: var(--accent-color);
        }
        
        .navbar-nav .nav-item {
            position: relative;
            margin-right: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .search-form {
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .navbar-nav .btn {
                width: 100%;
                text-align: left;
                margin: 0.25rem 0;
            }
        }
        
        /* Animation for dropdown */
        .dropdown-menu.show {
            animation: fadeInDown 0.3s ease forwards;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Main content area */
        main {
            min-height: calc(100vh - 76px);
            padding: 1.5rem 0;
        }
        
        /* Card styling */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="bi bi-palette me-2"></i> ArtiMart
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link {{ request()->routeIs('getCart') ? 'active' : '' }}" href="{{ route('getCart') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Cart
                                @if(session()->has('cart') && count(session()->get('cart')->items) > 0)
                                <span class="badge bg-accent rounded-pill position-absolute badge-cart">
                                    {{ count(session()->get('cart')->items) }}
                                </span>
                                @endif
                            </a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('orders.my') ? 'active' : '' }}" href="{{ route('orders.my') }}">
                                <i class="fas fa-box me-1"></i>My Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reviews.index') ? 'active' : '' }}" href="{{ route('reviews.index') }}">
                                <i class="fas fa-star me-1"></i>My Reviews
                            </a>
                        </li>
                        @endauth
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Search Form -->
                        <form class="search-form d-flex me-3" action="{{ route('search') }}" method="GET">
                            <span class="search-icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <input class="form-control" type="search" name="term" placeholder="Search products..." aria-label="Search">
                        </form>

                        @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary mx-1" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>{{ __('Login') }}
                                </a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary text-white mx-1" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>{{ __('Register') }}
                                </a>
                            </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle profile-dropdown-toggle" href="#" 
                                   role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" 
                                         class="rounded-circle profile-img" width="40" height="40">
                                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-circle me-2"></i>Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
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

        <main>
            @yield('content')
            @yield('body')
        </main>
        
        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h5 class="mb-3 fw-bold">ArtiMart</h5>
                        <p class="text-muted">Your premier marketplace for unique artisan products and handcrafted goods from around the world.</p>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <h6 class="fw-bold">Shop</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none text-muted">New Arrivals</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Trending</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Discounts</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <h6 class="fw-bold">Support</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none text-muted">FAQ</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Shipping</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Returns</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="fw-bold">Stay Connected</h6>
                        <p class="text-muted">Subscribe to our newsletter for updates and offers</p>
                        <form class="d-flex">
                            <input type="email" class="form-control me-2" placeholder="Your email">
                            <button class="btn btn-primary">Subscribe</button>
                        </form>
                        <div class="mt-3">
                            <a href="#" class="text-decoration-none text-white me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-decoration-none text-white me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-decoration-none text-white me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-decoration-none text-white"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-3 bg-secondary">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} ArtiMart. All rights reserved.</p>
                    <div>
                        <a href="#" class="text-decoration-none text-muted me-3">Privacy Policy</a>
                        <a href="#" class="text-decoration-none text-muted me-3">Terms of Service</a>
                        <a href="#" class="text-decoration-none text-muted">Contact Us</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>