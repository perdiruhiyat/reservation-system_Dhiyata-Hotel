```blade
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login') - Dhiyata Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --brand-primary: #0f766e;
            --brand-secondary: #0d9488;
            --brand-gold: #d4a017;
            --brand-dark: #102a2a;
            --brand-soft: rgba(13, 148, 136, .10);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 1.5rem;
            display: grid;
            place-items: center;
            font-family: 'Manrope', sans-serif;
            background:
                linear-gradient(rgba(6, 40, 38, .70),
                    rgba(15, 42, 42, .82)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85') center/cover fixed;
        }

        .back-home {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1rem;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 12px;
            background: rgba(255, 255, 255, .10);
            backdrop-filter: blur(12px);
            font-size: .88rem;
            font-weight: 700;
            text-decoration: none;
            transition: .2s ease;
        }

        .back-home:hover {
            color: #fff;
            background: rgba(255, 255, 255, .18);
            transform: translateY(-1px);
        }

        .auth-shell {
            width: 100%;
            max-width: 1080px;
            min-height: 650px;
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 30px;
            background: rgba(255, 255, 255, .93);
            box-shadow: 0 35px 100px rgba(2, 20, 19, .42);
            backdrop-filter: blur(20px);
        }

        .auth-visual {
            position: relative;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 3.25rem;
            color: #fff;
            background:
                linear-gradient(135deg,
                    rgba(6, 78, 72, .94),
                    rgba(13, 148, 136, .72)),
                url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1300&q=85') center/cover;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            top: -110px;
            right: -80px;
            border-radius: 50%;
            background: rgba(212, 160, 23, .22);
            filter: blur(2px);
        }

        .auth-visual::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            left: -100px;
            bottom: -100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
        }

        .visual-brand,
        .visual-copy,
        .visual-features {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 18px;
            background: rgba(255, 255, 255, .13);
            backdrop-filter: blur(12px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .12);
            font-size: 1.45rem;
        }

        .visual-brand h1 {
            margin-bottom: .25rem;
            font-size: 1.8rem;
            font-weight: 800;
        }

        .visual-copy {
            max-width: 520px;
        }

        .visual-copy h2 {
            margin-bottom: 1rem;
            font-size: clamp(2rem, 4vw, 3.1rem);
            font-weight: 800;
            line-height: 1.15;
        }

        .visual-copy h2 span {
            color: #f2c85c;
        }

        .visual-copy p {
            max-width: 470px;
            margin-bottom: 0;
            color: rgba(255, 255, 255, .72);
            line-height: 1.8;
        }

        .visual-features {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: rgba(255, 255, 255, .82);
            font-size: .85rem;
            font-weight: 600;
        }

        .feature-item i {
            color: #f2c85c;
        }

        .auth-panel {
            position: relative;
            display: flex;
            align-items: center;
            padding: 3.5rem;
            background: rgba(255, 255, 255, .96);
        }

        .auth-panel-inner {
            width: 100%;
        }

        .auth-panel::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            top: -80px;
            right: -70px;
            border-radius: 50%;
            background: var(--brand-soft);
        }

        .auth-panel>* {
            position: relative;
            z-index: 2;
        }

        .form-label {
            margin-bottom: .5rem;
            color: #344d4b;
            font-size: .9rem;
            font-weight: 700;
        }

        .form-control {
            min-height: 50px;
            padding: .75rem 1rem;
            border: 1px solid rgba(15, 118, 110, .18);
            border-radius: 14px;
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 .22rem rgba(13, 148, 136, .12);
        }

        .input-group .form-control {
            border-right: 0;
        }

        .input-group .btn {
            border: 1px solid rgba(15, 118, 110, .18);
            border-left: 0;
            border-radius: 0 14px 14px 0;
            background: #fff;
            color: #6b7f7e;
        }

        .btn {
            border-radius: 14px;
            font-weight: 750;
        }

        .btn-primary {
            min-height: 50px;
            border: 0;
            background: linear-gradient(135deg,
                    var(--brand-primary),
                    var(--brand-secondary));
            box-shadow: 0 13px 30px rgba(13, 148, 136, .24);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg,
                    #0b655f,
                    #0b8278);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            --bs-btn-color: var(--brand-primary);
            --bs-btn-border-color: var(--brand-primary);
            --bs-btn-hover-bg: var(--brand-primary);
            --bs-btn-hover-border-color: var(--brand-primary);
        }

        .form-check-input:checked {
            border-color: var(--brand-primary);
            background-color: var(--brand-primary);
        }

        .auth-link {
            color: var(--brand-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-link:hover {
            color: var(--brand-secondary);
            text-decoration: underline;
        }

        .alert {
            border: 0;
            border-radius: 14px;
        }

        @media (max-width: 991.98px) {
            body {
                padding: 1rem;
            }

            .auth-shell {
                max-width: 560px;
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 260px;
                padding: 2rem;
            }

            .visual-copy {
                margin-top: 2rem;
            }

            .visual-copy h2 {
                font-size: 2rem;
            }

            .visual-features {
                display: none;
            }

            .auth-panel {
                padding: 2.25rem;
            }
        }

        @media (max-width: 575.98px) {
            body {
                padding: .75rem;
                align-items: start;
            }

            .back-home {
                position: static;
                justify-self: start;
                margin-bottom: .75rem;
            }

            .auth-shell {
                border-radius: 22px;
            }

            .auth-visual {
                min-height: auto;
                padding: 1.5rem;
            }

            .visual-copy {
                display: none;
            }

            .auth-panel {
                padding: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <a href="{{ route('home') }}" class="back-home">
        <i class="bi bi-arrow-left"></i>
        Kembali ke Beranda
    </a>

    <div class="auth-shell">
        <section class="auth-visual">
            <div class="visual-brand">
                <div class="brand-badge">
                    <i class="bi bi-buildings-fill"></i>
                </div>

                <h1>Dhiyata Hotel</h1>

                <p class="text-white-50 mb-0">
                    Stay, Relax, and Reserve
                </p>
            </div>

            <div class="visual-copy">
                <h2>
                    Kenyamanan dimulai dari
                    <span>reservasi yang mudah.</span>
                </h2>

                <p>
                    Nikmati proses pemesanan kamar yang cepat, aman,
                    dan praktis untuk pengalaman menginap terbaik.
                </p>
            </div>

            <div class="visual-features">
                <div class="feature-item">
                    <i class="bi bi-check-circle-fill"></i>
                    Reservasi Online
                </div>

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill"></i>
                    QR Check-In
                </div>

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill"></i>
                    Layanan 24 Jam
                </div>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-panel-inner">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>