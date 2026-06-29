<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dhiyata Hotel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        (function () {
            const isDesktop = window.innerWidth >= 992;
            const isCollapsed =
                localStorage.getItem('dhiyataSidebarCollapsed') === '1';

            if (isDesktop && isCollapsed) {
                document.documentElement.classList.add('sidebar-collapsed-init');
            }
        })();
    </script>
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-mini: 88px;
            --brand-1: #0f766e;
            --brand-2: #0d9488;
            --brand-3: #d4a017;
            --sidebar-bg-1: #102a2a;
            --sidebar-bg-2: #163c3a;
            --brand-soft: rgba(13, 148, 136, .12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(13, 148, 136, .10), transparent 30%),
                radial-gradient(circle at top right, rgba(212, 160, 23, .08), transparent 25%),
                var(--bs-tertiary-bg);
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            width: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            padding: 1rem;
            color: #fff;
            background: linear-gradient(180deg,
                    var(--sidebar-bg-1),
                    var(--sidebar-bg-2));
            border-right: 1px solid rgba(255, 255, 255, .08);
            box-shadow: 14px 0 35px rgba(15, 42, 42, .14);
            transition:
                width .18s ease,
                transform .18s ease;
            overflow: visible;
        }

        .sidebar-header {
            position: relative;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: .8rem;
            min-height: 58px;
            padding: .25rem .35rem .9rem;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg,
                    var(--brand-2),
                    var(--brand-3));
            box-shadow: 0 10px 24px rgba(13, 148, 136, .25);
            font-size: 1.25rem;
        }

        .brand-copy {
            min-width: 0;
        }

        .brand-name {
            overflow: hidden;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .brand-subtitle {
            overflow: hidden;
            color: rgba(255, 255, 255, .5);
            font-size: .72rem;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .brand-copy,
        .menu-text,
        .sidebar-section,
        .profile-copy,
        .profile-arrow {
            transition:
                opacity .18s ease,
                visibility .18s ease,
                transform .18s ease;
        }

        .sidebar-toggle {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            margin-left: auto;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 11px;
            color: #fff;
            background: rgba(255, 255, 255, .09);
            transition:
                background .18s ease,
                transform .18s ease;
        }

        .sidebar-toggle:hover {
            color: #fff;
            background: rgba(255, 255, 255, .17);
        }

        #collapseSidebar {
            position: absolute;
            top: 62px;
            right: -18px;
            z-index: 5;
            margin: 0;
            color: #fff;
            background: linear-gradient(135deg,
                    var(--brand-1),
                    var(--brand-2));
            box-shadow: 0 8px 20px rgba(15, 42, 42, .22);
        }

        .sidebar-body {
            flex: 1;
            min-height: 0;
            padding-top: 1rem;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .18) transparent;
        }

        .sidebar-body::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-body::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: rgba(255, 255, 255, .18);
        }

        .sidebar-section {
            margin: .75rem .7rem .45rem;
            color: rgba(255, 255, 255, .4);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .8rem;
            min-height: 48px;
            padding: .82rem .9rem;
            margin-bottom: .2rem;
            border-radius: 14px;
            color: rgba(255, 255, 255, .72);
            font-weight: 650;
            text-decoration: none;
            white-space: nowrap;
            transition:
                color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .sidebar .nav-link i {
            width: 22px;
            flex-shrink: 0;
            text-align: center;
            font-size: 1.05rem;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .09);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg,
                    rgba(15, 118, 110, .96),
                    rgba(13, 148, 136, .96));
            box-shadow: 0 10px 24px rgba(13, 148, 136, .20);
        }

        .sidebar-footer {
            flex-shrink: 0;
            margin-top: auto;
            padding-top: .9rem;
            border-top: 1px solid rgba(255, 255, 255, .10);
        }

        .profile-box {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem;
            border: 1px solid rgba(255, 255, 255, .08) !important;
            border-radius: 15px;
            color: #fff;
            background: rgba(255, 255, 255, .06);
            text-align: left;
            cursor: pointer;
            transition:
                background .18s ease,
                border-color .18s ease;
        }

        .profile-box:hover,
        .profile-box[aria-expanded="true"] {
            color: #fff;
            background: rgba(255, 255, 255, .11);
            border-color: rgba(255, 255, 255, .15) !important;
        }

        .profile-avatar {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg,
                    var(--brand-2),
                    var(--brand-3));
            font-weight: 800;
        }

        .profile-copy {
            min-width: 0;
        }

        .profile-arrow {
            margin-left: auto;
            color: rgba(255, 255, 255, .55);
        }

        .profile-box[aria-expanded="true"] .profile-arrow {
            transform: rotate(180deg);
        }

        .sidebar-profile-menu {
            min-width: 230px;
            padding: .5rem;
            border: 1px solid rgba(15, 118, 110, .16);
            border-radius: 14px;
            box-shadow: 0 16px 38px rgba(15, 42, 42, .18);
        }

        .sidebar-profile-menu .dropdown-item {
            padding: .7rem .8rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .sidebar-profile-menu .dropdown-item:hover {
            color: var(--brand-1);
            background: var(--brand-soft);
        }

        .main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            transition: margin-left .18s ease;
        }

        /* SIDEBAR MINI */

        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-mini);
        }

        body.sidebar-collapsed .main {
            margin-left: var(--sidebar-mini);
        }

        body.sidebar-collapsed .brand-copy,
        body.sidebar-collapsed .menu-text,
        body.sidebar-collapsed .sidebar-section,
        body.sidebar-collapsed .profile-copy,
        body.sidebar-collapsed .profile-arrow {
            width: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-8px);
            pointer-events: none;
        }

        body.sidebar-collapsed .sidebar-header {
            justify-content: center;
            padding-inline: 0;
        }

        body.sidebar-collapsed .sidebar .nav-link {
            justify-content: center;
            gap: 0;
            padding-inline: .7rem;
        }

        body.sidebar-collapsed .sidebar .nav-link:hover {
            transform: none;
        }

        body.sidebar-collapsed .profile-box {
            justify-content: center;
            gap: 0;
            padding: .55rem;
        }

        body.sidebar-collapsed .sidebar-profile-menu {
            width: 230px !important;
        }

        html.sidebar-collapsed-init .sidebar {
            width: var(--sidebar-mini);
        }

        html.sidebar-collapsed-init .main {
            margin-left: var(--sidebar-mini);
        }

        html.sidebar-collapsed-init .brand-copy,
        html.sidebar-collapsed-init .menu-text,
        html.sidebar-collapsed-init .sidebar-section,
        html.sidebar-collapsed-init .profile-copy,
        html.sidebar-collapsed-init .profile-arrow {
            width: 0;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        html.sidebar-collapsed-init .sidebar-header {
            justify-content: center;
            padding-inline: 0;
        }

        html.sidebar-collapsed-init .sidebar .nav-link {
            justify-content: center;
            gap: 0;
            padding-inline: .7rem;
        }

        html.sidebar-collapsed-init .profile-box {
            justify-content: center;
            gap: 0;
            padding: .55rem;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, .72);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(148, 163, 184, .18);
        }

        [data-bs-theme="dark"] .topbar {
            background: rgba(17, 24, 39, .72);
        }

        .content-wrap {
            padding: 1.5rem;
            animation: pageEnter .35s ease both;
        }

        .card,
        .stat-card {
            border: 1px solid rgba(148, 163, 184, .14);
            border-radius: 22px;
            background: var(--bs-body-bg);
            box-shadow: 0 18px 45px rgba(15, 118, 110, .08);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .card:hover {
            box-shadow: 0 22px 55px rgba(15, 118, 110, .11);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .card .card-body {
            padding: 1.35rem;
        }

        .btn {
            border-radius: 12px;
            font-weight: 700;
            transition: transform .18s ease, filter .18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
            box-shadow: 0 10px 24px rgba(13, 148, 136, .20);
        }

        .form-control,
        .form-select {
            min-height: 44px;
            border-radius: 12px;
            border-color: rgba(148, 163, 184, .28);
        }

        .table {
            --bs-table-bg: transparent;
        }

        .table tbody tr {
            transition: background .18s ease;
        }

        .table tbody tr:hover {
            background: rgba(13, 148, 136, .05);
        }

        .mobile-topbar {
            display: none;
        }

        #sideBackdrop {
            position: fixed;
            inset: 0;
            z-index: 1035;
            display: none;
            background: rgba(2, 6, 23, .52);
            backdrop-filter: blur(2px);
            pointer-events: none;
        }

        #sideBackdrop.show {
            display: block;
            pointer-events: auto;
        }

        body.mobile-sidebar-open {
            overflow: hidden;
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        [data-bs-theme="dark"] .sidebar-profile-menu {
            background: #173332;
            border-color: rgba(255, 255, 255, .10);
        }

        [data-bs-theme="dark"] .sidebar-profile-menu .dropdown-item {
            color: rgba(255, 255, 255, .82);
        }

        [data-bs-theme="dark"] .sidebar-profile-menu .dropdown-item:hover {
            color: #fff;
            background: rgba(13, 148, 136, .18);
        }

        @media (max-width: 991.98px) {

            .sidebar,
            body.sidebar-collapsed .sidebar {
                width: min(var(--sidebar-width), calc(100vw - 56px));
                transform: translateX(-105%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main,
            body.sidebar-collapsed .main {
                margin-left: 0;
            }

            body.sidebar-collapsed .brand-copy,
            body.sidebar-collapsed .menu-text,
            body.sidebar-collapsed .sidebar-section,
            body.sidebar-collapsed .profile-copy,
            body.sidebar-collapsed .profile-arrow {
                width: auto;
                opacity: 1;
                visibility: visible;
                transform: none;
                pointer-events: auto;
            }

            body.sidebar-collapsed .sidebar-header {
                justify-content: flex-start;
                padding: .25rem .35rem .9rem;
            }

            body.sidebar-collapsed .sidebar .nav-link {
                justify-content: flex-start;
                gap: .8rem;
                padding: .82rem .9rem;
            }

            body.sidebar-collapsed .profile-box {
                justify-content: flex-start;
                gap: .75rem;
                padding: .75rem;
            }

            .desktop-topbar {
                display: none !important;
            }

            .mobile-topbar {
                position: sticky;
                top: 0;
                z-index: 1020;
                display: flex;
                background: rgba(255, 255, 255, .88);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(148, 163, 184, .18);
            }

            [data-bs-theme="dark"] .mobile-topbar {
                background: rgba(17, 24, 39, .88);
            }

            .content-wrap {
                padding: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .content-wrap {
                padding: .8rem;
            }

            .page-actions {
                display: grid !important;
                width: 100%;
                gap: .55rem;
            }

            .page-actions .btn {
                width: 100%;
            }

            .table {
                min-width: 760px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-logo"><i class="bi bi-buildings-fill"></i></div>

            <div class="brand-copy">
                <div class="brand-name">Dhiyata Hotel</div>
                <div class="brand-subtitle">Reservation Management</div>
            </div>

            <button type="button" class="sidebar-toggle d-none d-lg-grid" id="collapseSidebar">
                <i class="bi bi-chevron-left" id="collapseIcon"></i>
            </button>

            <button type="button" class="sidebar-toggle d-lg-none" onclick="toggleMobileSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="sidebar-body">
            <div class="sidebar-section">Menu Utama</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}" title="Dashboard">
                    <i class="bi bi-grid-1x2-fill"></i><span class="menu-text">Dashboard</span>
                </a>

                <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}"
                    href="{{ route('bookings.index') }}" title="Reservasi">
                    <i class="bi bi-calendar2-check-fill"></i><span class="menu-text">Reservasi</span>
                </a>

                <a class="nav-link {{ request()->routeIs('guests.*') ? 'active' : '' }}"
                    href="{{ route('guests.index') }}" title="Data Tamu">
                    <i class="bi bi-people-fill"></i><span class="menu-text">Data Tamu</span>
                </a>

                <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}"
                    href="{{ route('rooms.index') }}" title="Data Kamar">
                    <i class="bi bi-door-open-fill"></i><span class="menu-text">Data Kamar</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a class="nav-link {{ request()->routeIs('room-types.*') ? 'active' : '' }}"
                        href="{{ route('room-types.index') }}" title="Tipe Kamar">
                        <i class="bi bi-tags-fill"></i><span class="menu-text">Tipe Kamar</span>
                    </a>

                    <a class="nav-link {{ request()->routeIs('facilities.*') ? 'active' : '' }}"
                        href="{{ route('facilities.index') }}" title="Fasilitas">
                        <i class="bi bi-stars"></i><span class="menu-text">Fasilitas</span>
                    </a>

                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                        href="{{ route('reports.reservations') }}" title="Laporan">
                        <i class="bi bi-bar-chart-fill"></i><span class="menu-text">Laporan</span>
                    </a>
                @endif
            </nav>
        </div>

        <footer class="sidebar-footer">
            <div class="dropup w-100">
                <button class="profile-box border-0 w-100 text-start" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="profile-copy flex-grow-1 min-w-0">
                        <div class="fw-bold text-truncate">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="small text-white-50 text-capitalize">
                            {{ auth()->user()->role }}
                        </div>
                    </div>

                    <i class="bi bi-chevron-up profile-arrow"></i>
                </button>

                <ul class="dropdown-menu sidebar-profile-menu w-100 mb-2">
                    <li>
                        <div class="px-3 py-2">
                            <div class="fw-bold">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="small text-secondary text-capitalize">
                                {{ auth()->user()->role }}
                            </div>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" id="themeToggle">
                            <i class="bi bi-moon-stars"></i>
                            <span>Ganti Tema</span>
                        </button>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </footer>
    </aside>

    <div class="main">
        <div class="topbar desktop-topbar d-flex align-items-center justify-content-between">
            <div>
                <div class="small text-secondary">Selamat datang kembali</div>
                <div class="fw-bold">{{ auth()->user()->name }}</div>
            </div>

            <span class="badge text-bg-light border">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M Y') }}
            </span>
        </div>

        <div class="mobile-topbar align-items-center justify-content-between px-3 py-2">
            <button class="btn" onclick="toggleMobileSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="fw-bold">
                <i class="bi bi-buildings-fill text-primary me-1"></i>Dhiyata Hotel
            </div>

            <button class="btn" id="mobileTheme">
                <i class="bi bi-circle-half"></i>
            </button>
        </div>

        <main class="content-wrap">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <strong>Periksa kembali input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <div id="sideBackdrop" aria-hidden="true"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pageBody = document.body;
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sideBackdrop');
            const collapseButton = document.getElementById(
                'collapseSidebar'
            );
            const collapseIcon = document.getElementById(
                'collapseIcon'
            );

            const themeToggle = document.getElementById(
                'themeToggle'
            );

            const mobileTheme = document.getElementById(
                'mobileTheme'
            );

            function isDesktop() {
                return window.innerWidth >= 992;
            }

            function updateCollapseIcon() {
                if (!collapseIcon) {
                    return;
                }

                collapseIcon.className =
                    pageBody.classList.contains('sidebar-collapsed')
                        ? 'bi bi-chevron-right'
                        : 'bi bi-chevron-left';
            }

            function applySavedSidebarState() {
                if (!isDesktop()) {
                    pageBody.classList.remove('sidebar-collapsed');

                    document.documentElement.classList.remove(
                        'sidebar-collapsed-init'
                    );

                    return;
                }

                const collapsed =
                    localStorage.getItem(
                        'dhiyataSidebarCollapsed'
                    ) === '1';

                pageBody.classList.toggle(
                    'sidebar-collapsed',
                    collapsed
                );

                document.documentElement.classList.remove(
                    'sidebar-collapsed-init'
                );

                updateCollapseIcon();
            }

            function toggleDesktopSidebar() {
                if (!isDesktop()) {
                    return;
                }

                pageBody.classList.toggle('sidebar-collapsed');

                localStorage.setItem(
                    'dhiyataSidebarCollapsed',
                    pageBody.classList.contains(
                        'sidebar-collapsed'
                    ) ? '1' : '0'
                );

                updateCollapseIcon();
            }

            function openMobileSidebar() {
                if (isDesktop()) {
                    return;
                }

                sidebar.classList.add('show');
                backdrop.classList.add('show');
                pageBody.classList.add('mobile-sidebar-open');

                backdrop.setAttribute(
                    'aria-hidden',
                    'false'
                );
            }

            function closeMobileSidebar() {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
                pageBody.classList.remove(
                    'mobile-sidebar-open'
                );

                backdrop.setAttribute(
                    'aria-hidden',
                    'true'
                );
            }

            window.toggleMobileSidebar = function () {
                if (sidebar.classList.contains('show')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            };

            function toggleTheme() {
                const html = document.documentElement;

                const currentTheme =
                    html.getAttribute('data-bs-theme') ||
                    'light';

                const nextTheme =
                    currentTheme === 'dark'
                        ? 'light'
                        : 'dark';

                html.setAttribute(
                    'data-bs-theme',
                    nextTheme
                );

                localStorage.setItem(
                    'theme',
                    nextTheme
                );
            }

            document.documentElement.setAttribute(
                'data-bs-theme',
                localStorage.getItem('theme') || 'light'
            );

            applySavedSidebarState();

            collapseButton?.addEventListener(
                'click',
                toggleDesktopSidebar
            );

            themeToggle?.addEventListener(
                'click',
                toggleTheme
            );

            mobileTheme?.addEventListener(
                'click',
                toggleTheme
            );

            backdrop?.addEventListener(
                'click',
                closeMobileSidebar
            );

            sidebar
                .querySelectorAll('.nav-link')
                .forEach(function (link) {
                    link.addEventListener(
                        'click',
                        function () {
                            if (!isDesktop()) {
                                closeMobileSidebar();
                            }
                        }
                    );
                });

            document.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Escape' &&
                        sidebar.classList.contains('show')
                    ) {
                        closeMobileSidebar();
                    }
                }
            );

            window.addEventListener(
                'resize',
                function () {
                    if (isDesktop()) {
                        closeMobileSidebar();
                        applySavedSidebarState();
                    } else {
                        pageBody.classList.remove(
                            'sidebar-collapsed'
                        );

                        updateCollapseIcon();
                    }
                }
            );
        });
    </script>

    @stack('scripts')
</body>

</html>