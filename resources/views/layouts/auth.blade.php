<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Dhiyata Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background:
                linear-gradient(rgba(15, 23, 42, .58), rgba(15, 23, 42, .72)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80') center/cover fixed;
            display: grid;
            place-items: center;
            padding: 1rem;
        }

        .auth-shell {
            width: 100%;
            max-width: 1050px;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            overflow: hidden;
            border-radius: 28px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 30px 90px rgba(2, 6, 23, .35);
            backdrop-filter: blur(18px);
        }

        .auth-visual {
            padding: 3rem;
            color: #fff;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(135deg, rgba(79, 70, 229, .86), rgba(124, 58, 237, .80)),
                url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1200&q=80') center/cover;
        }

        .auth-panel {
            padding: 3rem;
            background: rgba(255, 255, 255, .94);
        }

        .brand-badge {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(10px);
            font-size: 1.35rem;
        }

        .form-control {
            min-height: 48px;
            border-radius: 14px;
        }

        .btn-primary {
            min-height: 48px;
            border: 0;
            border-radius: 14px;
            font-weight: 800;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 12px 30px rgba(99, 102, 241, .25);
        }

        @media (max-width: 767.98px) {
            .auth-shell {
                grid-template-columns: 1fr;
                max-width: 480px;
            }

            .auth-visual {
                min-height: auto;
                padding: 1.5rem;
            }

            .auth-visual .visual-copy {
                display: none;
            }

            .auth-panel {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <section class="auth-visual">
            <div>
                <div class="brand-badge mb-3">
                    <i class="bi bi-buildings-fill"></i>
                </div>

                <h1 class="fw-bold mb-1">Dhiyata Hotel</h1>
                <p class="text-white-50 mb-0">Stay, Relax, and Reserve</p>
            </div>

            <div class="visual-copy">
                <h2 class="display-6 fw-bold">Temukan pengalaman menginap yang nyaman bersama Dhiyata Hotel.</h2>
                <p class="lead text-white-50 mb-0">
                    Pesan kamar secara online dengan proses yang mudah, cepat, dan aman.
                </p>
            </div>
        </section>

        <section class="auth-panel">
            @yield('content')
        </section>
    </div>
</body>

</html>