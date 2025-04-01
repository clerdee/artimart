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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #F4F9F9;
        }

        /* Navbar Styling */
        .navbar-brand {
            color: #FF6F61;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-dark {
            background: linear-gradient(to right, #A8DADC, #457B9D);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-dark .navbar-brand {
            color: #FF6F61;
            font-weight: bold;
        }

        .navbar-dark .navbar-brand:hover {
            color: #E63946;
        }

        .navbar-dark .nav-link {
            color: #FF6F61;
        }

        .navbar-dark .nav-link:hover {
            color: #E63946;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 56px;
            left: 0;
            height: calc(100% - 56px);
            background: linear-gradient(to bottom, #F1FAEE, #A8DADC);
            padding-top: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }

        .sidebar a {
            color: #457B9D;
            padding: 12px 20px;
            margin: 4px 10px;
            display: block;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .sidebar a:hover {
            background: #A8DADC;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: #457B9D;
            color: white;
        }

        .sidebar i {
            margin-right: 10px;
            width: 24px;
            text-align: center;
        }

        /* User Avatar */
        .user-dropdown img {
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 10px 20px;
            border-radius: 8px;
            margin: 5px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #F1FAEE;
            transform: translateX(5px);
        }

        /* Main Content Area */
        main {
            margin-left: 250px;
            padding: 80px 30px 30px 30px;
            min-height: 100vh;
            background-color: #F4F9F9;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding-top: 10px;
            }
            
            .sidebar a {
                padding: 12px 5px;
                margin: 5px;
                text-align: center;
            }
            
            .sidebar a span {
                display: none;
            }
            
            .sidebar i {
                margin-right: 0;
                font-size: 20px;
            }
            
            main {
                margin-left: 70px;
                padding: 70px 15px 15px 15px;
            }
        }
    </style>
</head>

<body>
<nav class="navbar navbar-dark fixed-top px-3">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand fw-bold">
                <i class="bi bi-palette"></i> ArtiMart Admin Panel
            </a>

            <div class="d-flex align-items-center">
                <div class="dropdown user-dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center text-dark rounded-pill bg-white shadow-sm py-1 px-3" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image"
                            class="rounded-circle" width="40" height="40">
                        <span class="ms-2 fw-semibold">{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle text-primary"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <a href="{{ route('dashboard.index') }}" class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="bi bi-house"></i> <span>DASHBOARD</span>
        </a>
        <a href="{{ route('admin.items') }}" class="{{ Request::routeIs('admin.items') ? 'active' : '' }}">
            <i class="bi bi-box"></i> <span>PRODUCT</span>
        </a>
        <a href="{{ route('admin.orders') }}" class="{{ Request::routeIs('admin.orders') ? 'active' : '' }}">
            <i class="bi bi-card-list"></i> <span>ORDER</span>
        </a>
        <a href="{{ route('admin.users') }}" class="{{ Request::routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>USER</span>
        </a>
        <a href="{{ route('admin.reviews') }}" class="{{ Request::routeIs('admin.reviews') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text"></i> <span>FEEDBACK</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="{{ Request::routeIs('admin.categories') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> <span>CATEGORY</span>
        </a> 
    </div>

    <main>
        @yield('content')
        @yield('body')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>