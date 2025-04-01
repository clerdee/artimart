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
        }

        .navbar-brand {
            color: #1565C0;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-dark {
            background-color: #b3d9ff; /* Light blue for navbar */
        }

        .navbar-dark .navbar-brand {
            color: #1565C0; /* Dark blue for branding */
            font-weight: bold;
        }

        .navbar-dark .navbar-brand:hover {
            color: #003d80; /* Darker blue on hover */
        }

        .navbar-dark .nav-link {
            color: #1565C0; /* Dark blue for links */
        }

        .navbar-dark .nav-link:hover {
            color: #003d80; /* Darker blue on hover */
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 56px; /* height of navbar */
            left: 0;
            height: calc(100% - 56px);
            background: #E3F2FD; /* Lightest blue for sidebar */
            padding-top: 20px;
            overflow-y: auto;
        }

        .sidebar a {
            color: #1565C0; /* Dark blue for sidebar links */
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #BBDEFB; /* Slightly darker blue on hover */
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: #E3F2FD; /* Light blue for avatar */
            color: #1565C0; /* Dark blue for text */
            font-weight: bold;
            text-align: center;
            border-radius: 50%;
            line-height: 35px;
        }

        main {
            margin-left: 250px;
            padding: 80px 30px 30px 30px; /* Space below navbar */
            min-height: 100vh;
            background-color: #F8F9FA; /* Light gray for main content */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top px-3">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand fw-bold">
                <i class="bi bi-bag-heart"></i> SquishIT Admin
            </a>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image"
                            class="rounded-circle" width="40" height="40">
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
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
        <a href="{{ route('dashboard.index') }}"><i class="bi bi-house"></i> Dashboard</a>
        <a href="{{ route('admin.orders') }}"><i class="bi bi-card-list"></i> Orders</a>
        <a href="{{ route('admin.users') }}"><i class="bi bi-people"></i> Users</a>
        <a href="{{ route('admin.categories') }}"><i class="bi bi-tags"></i> Categories</a> 
        <a href="{{ route('admin.items') }}"><i class="bi bi-box"></i> Items</a>
        <a href="{{ route('admin.reviews') }}"><i class="bi bi-chat-left-text"></i> Reviews</a>
    </div>

    <main>
        @yield('content')
        @yield('body')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>