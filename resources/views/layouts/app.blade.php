<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multi-Vendor Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-white text-black dark:bg-gray-900 dark:text-gray-200">

<nav class="navbar navbar-expand-lg navbar-light bg-light p-3 dark:bg-gray-800">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Shop</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cart') }}">Cart</a>
            </li>
            @auth
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link nav-link" type="submit">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endauth
            <li class="nav-item">
                <button id="dark-toggle" class="btn btn-sm btn-secondary ms-2">🌙 Dark Mode</button>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Page content --}}
    @yield('content')
</div>

<script>
    const toggle = document.getElementById('dark-toggle');
    const html = document.documentElement;

    toggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    if(localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    }
</script>
</body>
</html>