<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dhiyata Hotel')
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-1: #0f766e;
            --brand-2: #0d9488;
            --brand-3: #d4a017;
            --brand-soft: rgba(13, 148, 136, .10);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at top left,
                    rgba(13, 148, 136, .10),
                    transparent 30%),
                radial-gradient(circle at top right,
                    rgba(212, 160, 23, .08),
                    transparent 25%),
                #f7faf9;
        }

        .navbar {
            background: rgba(255, 255, 255, .90);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(15, 118, 110, .08);
            box-shadow: 0 8px 30px rgba(15, 42, 42, .06);
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            display: inline-grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(135deg,
                    var(--brand-2),
                    var(--brand-3));
            box-shadow: 0 10px 24px rgba(13, 148, 136, .20);
        }

        .navbar .nav-link {
            padding: .65rem .85rem;
            color: #49605f;
            font-weight: 650;
            border-radius: 10px;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--brand-1);
            background: var(--brand-soft);
        }

        .hero {
            border-radius: 28px;
            color: #fff;
            background:
                linear-gradient(135deg,
                    rgba(15, 118, 110, .94),
                    rgba(13, 148, 136, .78)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80') center/cover;
            box-shadow: 0 24px 60px rgba(15, 118, 110, .18);
        }

        .card {
            border: 1px solid rgba(15, 118, 110, .08);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 42, 42, .07);
        }

        .btn {
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-primary {
            --bs-btn-bg: var(--brand-1);
            --bs-btn-border-color: var(--brand-1);
            --bs-btn-hover-bg: #0b655f;
            --bs-btn-hover-border-color: #0b655f;
            --bs-btn-active-bg: #095b56;
            --bs-btn-active-border-color: #095b56;

            border: 0;
            background: linear-gradient(135deg,
                    var(--brand-1),
                    var(--brand-2));
            box-shadow: 0 10px 24px rgba(13, 148, 136, .18);
        }

        .btn-outline-primary {
            --bs-btn-color: var(--brand-1);
            --bs-btn-border-color: var(--brand-1);
            --bs-btn-hover-bg: var(--brand-1);
            --bs-btn-hover-border-color: var(--brand-1);
            --bs-btn-active-bg: var(--brand-1);
            --bs-btn-active-border-color: var(--brand-1);
        }

        .text-primary {
            color: var(--brand-1) !important;
        }

        .bg-primary {
            background-color: var(--brand-1) !important;
        }

        .text-bg-primary {
            background-color: var(--brand-1) !important;
        }

        .border-primary {
            border-color: var(--brand-1) !important;
        }

        .form-control,
        .form-select {
            min-height: 46px;
            border-radius: 12px;
            border-color: rgba(15, 118, 110, .18);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand-2);
            box-shadow: 0 0 0 .22rem rgba(13, 148, 136, .12);
        }

        .user-footer {
            margin-top: 4rem;
            padding: 2rem 0;
            color: #6c807f;
            border-top: 1px solid rgba(15, 118, 110, .08);
        }

        .dropdown-menu {
            padding: .55rem;
            border: 1px solid rgba(15, 118, 110, .10);
            border-radius: 14px;
            box-shadow: 0 18px 45px rgba(15, 42, 42, .12);
        }

        .dropdown-item {
            padding: .65rem .75rem;
            border-radius: 9px;
        }

        @media print {

            .navbar,
            .user-footer,
            .no-print,
            .alert {
                display: none !important;
            }

            body {
                background: #fff !important;
            }

            main.container {
                width: 100% !important;
                max-width: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top no-print">
        <div class="container py-2">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-logo">
                    <i class="bi bi-buildings-fill"></i>
                </span>

                <span>Dhiyata Hotel</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav"
                aria-controls="userNav" aria-expanded="false" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="userNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home', 'user.home') ? 'active' : '' }}"
                            href="{{ route('home') }}">
                            Beranda
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user.bookings.index', 'user.bookings.show') ? 'active' : '' }}"
                                    href="{{ route('user.bookings.index') }}">
                                    Reservasi Saya
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('user.bookings.create') }}">
                                    <i class="bi bi-calendar2-plus me-1"></i>
                                    Pesan Kamar
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ auth()->user()->name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                            href="{{ route('user.profile.edit') }}">
                                            <i class="bi bi-person-circle"></i>
                                            Profil Saya
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-box-arrow-right me-1"></i>
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Login
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>
                                Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="user-footer no-print">
        <div class="container d-flex flex-wrap justify-content-between gap-2">
            <div class="fw-bold text-dark">
                Dhiyata Hotel
            </div>

            <div class="small">
                Reservasi nyaman, proses lebih praktis.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 700,
                easing: 'ease-out-cubic',
                once: true,
                offset: 80,
                delay: 0,
                anchorPlacement: 'top-bottom'
            });
        });
    </script>
</body>

</html>