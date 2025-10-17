<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kawa-Nda')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tailwind + JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert --}}
    @include('sweetalert::alert')
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🌸 Kawa-Nda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav me-auto">
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-white me-3">
                            👋 Hai, {{ Auth::user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        {{-- Logout pakai POST (sesuai route bawaan Laravel Breeze/Fortify) --}}
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten Halaman --}}
    <div class="container-fluid p-0">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
