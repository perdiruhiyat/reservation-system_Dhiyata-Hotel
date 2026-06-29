@extends('layouts.user')

@section('title', 'Dhiyata Hotel')

@section('content')
    {{-- HERO --}}
    <section class="hero-section" data-aos="fade-up" data-aos-duration="800">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="bi bi-stars me-1"></i>
                Pengalaman Menginap Terbaik
            </div>

            <h1>
                Temukan Kenyamanan
                <span>di Dhiyata Hotel</span>
            </h1>

            <p>
                Nikmati kamar yang nyaman, pelayanan terbaik, serta proses
                reservasi online yang cepat dan mudah.
            </p>

            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('user.bookings.create') }}" class="btn btn-light btn-lg px-4">
                    <i class="bi bi-calendar2-check me-2"></i>
                    Pesan Sekarang
                </a>

                <a href="#availableRooms" class="btn btn-outline-light btn-lg px-4">
                    Lihat Kamar
                    <i class="bi bi-arrow-down ms-2"></i>
                </a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>{{ $availableRooms->count() }}</strong>
                    <span>Kamar Tersedia</span>
                </div>

                <div>
                    <strong>24/7</strong>
                    <span>Layanan Hotel</span>
                </div>

                <div>
                    <strong>QR</strong>
                    <span>Check-In Cepat</span>
                </div>
            </div>
        </div>
    </section>

    {{-- QUICK BOOKING --}}
    <section class="quick-booking" data-aos="fade-up" data-aos-delay="100">
        <div class="quick-booking-card">
            <div>
                <div class="section-kicker">
                    Reservasi Mudah
                </div>

                <h2 class="h4 fw-bold mb-1">
                    Siap merencanakan penginapan?
                </h2>

                <p class="text-secondary mb-0">
                    Pilih tanggal dan kamar favorit Anda dalam beberapa langkah.
                </p>
            </div>

            <a href="{{ route('user.bookings.create') }}" class="btn btn-primary btn-lg">
                Mulai Reservasi
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </section>

    {{-- AVAILABLE ROOMS --}}
    <section id="availableRooms" class="landing-section" data-aos="fade-up">
        <div class="section-heading">
            <div>
                <div class="section-kicker">
                    Pilihan Kamar
                </div>

                <h2 class="fw-bold mb-2">
                    Kamar yang Tersedia
                </h2>

                <p class="text-secondary mb-0">
                    Pilih kamar sesuai kebutuhan dan kenyamanan Anda.
                </p>
            </div>

            <a href="{{ route('user.bookings.create') }}" class="btn btn-outline-primary">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4 mt-1">
            @forelse($availableRooms->take(6) as $room)
                    <div class="col-12 col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <article class="room-card h-100">
                            <div class="room-image">
                                <img src="{{ $room->roomType->image
                    ? asset('storage/images/room-types/' . $room->roomType->image)
                    : asset('images/room-placeholder.jpg') }}" alt="{{ $room->roomType->name }}">

                                <span class="availability-badge">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Tersedia
                                </span>

                                <div class="room-number">
                                    Kamar {{ $room->room_number }}
                                </div>
                            </div>

                            <div class="room-body">
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <h3 class="h5 fw-bold mb-1">
                                            {{ $room->roomType->name }}
                                        </h3>

                                        <div class="small text-secondary">
                                            Lantai {{ $room->floor }}
                                        </div>
                                    </div>

                                    <div class="room-capacity">
                                        <i class="bi bi-people"></i>
                                        {{ $room->roomType->capacity }}
                                    </div>
                                </div>

                                <p class="text-secondary small mt-3 mb-0 room-description">
                                    {{ Str::limit(
                    $room->roomType->description
                    ?: 'Kamar nyaman dengan fasilitas lengkap untuk pengalaman menginap terbaik.',
                    100
                ) }}
                                </p>

                                <div class="room-footer">
                                    <div>
                                        <div class="small text-secondary">
                                            Mulai dari
                                        </div>

                                        <div class="room-price">
                                            Rp {{ number_format(
                    $room->roomType->base_price,
                    0,
                    ',',
                    '.'
                ) }}
                                        </div>

                                        <div class="small text-secondary">
                                            per malam
                                        </div>
                                    </div>

                                    <a href="{{ route('user.bookings.create') }}" class="btn btn-primary">
                                        Pesan
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-door-closed"></i>
                        </div>

                        <h3 class="h5 fw-bold">
                            Belum ada kamar tersedia
                        </h3>

                        <p class="text-secondary mb-0">
                            Silakan periksa kembali pada waktu lain.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    {{-- FACILITIES --}}
    <section class="landing-section">
        <div class="text-center mb-5">
            <div class="section-kicker">
                Fasilitas Hotel
            </div>

            <h2 class="fw-bold mb-2">
                Kenyamanan untuk Setiap Tamu
            </h2>

            <p class="text-secondary mb-0">
                Berbagai fasilitas tersedia untuk mendukung kenyamanan Anda.
            </p>
        </div>

        <div class="row g-4">
            @php
                $facilities = [
                    [
                        'icon' => 'bi-wifi',
                        'title' => 'Wi-Fi Gratis',
                        'description' => 'Koneksi internet tersedia di area hotel.',
                    ],
                    [
                        'icon' => 'bi-cup-hot',
                        'title' => 'Sarapan',
                        'description' => 'Pilihan menu sarapan untuk memulai hari.',
                    ],
                    [
                        'icon' => 'bi-car-front',
                        'title' => 'Area Parkir',
                        'description' => 'Area parkir tersedia untuk kendaraan tamu.',
                    ],
                    [
                        'icon' => 'bi-shield-check',
                        'title' => 'Keamanan',
                        'description' => 'Sistem keamanan dan pelayanan selama 24 jam.',
                    ],
                ];
            @endphp

            @foreach($facilities as $facility)
                <div class="col-12 col-sm-6 col-xl-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="facility-card h-100">
                        <div class="facility-icon">
                            <i class="bi {{ $facility['icon'] }}"></i>
                        </div>

                        <h3 class="h5 fw-bold">
                            {{ $facility['title'] }}
                        </h3>

                        <p class="text-secondary mb-0">
                            {{ $facility['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="landing-section">
        <div class="process-section">
            <div class="text-center mb-5">
                <div class="section-kicker">
                    Cara Reservasi
                </div>

                <h2 class="fw-bold mb-2">
                    Pesan Kamar dalam 3 Langkah
                </h2>

                <p class="text-secondary mb-0">
                    Proses reservasi online yang cepat dan sederhana.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="process-card">
                        <div class="process-number">1</div>

                        <div class="process-icon">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <h3 class="h5 fw-bold">
                            Pilih Tanggal
                        </h3>

                        <p class="text-secondary mb-0">
                            Tentukan tanggal check-in dan check-out.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="process-card">
                        <div class="process-number">2</div>

                        <div class="process-icon">
                            <i class="bi bi-door-open"></i>
                        </div>

                        <h3 class="h5 fw-bold">
                            Pilih Kamar
                        </h3>

                        <p class="text-secondary mb-0">
                            Pilih kamar yang tersedia sesuai kebutuhan.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="process-card">
                        <div class="process-number">3</div>

                        <div class="process-icon">
                            <i class="bi bi-qr-code"></i>
                        </div>

                        <h3 class="h5 fw-bold">
                            Dapatkan QR
                        </h3>

                        <p class="text-secondary mb-0">
                            Gunakan QR reservasi untuk proses check-in.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RECENT BOOKINGS --}}
    @if($recentBookings->isNotEmpty())
        <section class="landing-section">
            <div class="section-heading">
                <div>
                    <div class="section-kicker">
                        Aktivitas Anda
                    </div>

                    <h2 class="fw-bold mb-2">
                        Reservasi Terbaru
                    </h2>

                    <p class="text-secondary mb-0">
                        Pantau status reservasi yang telah dibuat.
                    </p>
                </div>

                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-primary">
                    Semua Reservasi
                </a>
            </div>

            <div class="recent-bookings mt-4">
                @foreach($recentBookings as $booking)
                    <a href="{{ route('user.bookings.show', $booking) }}" class="recent-booking-item" data-aos="fade-left"
                        data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="booking-icon">
                            <i class="bi bi-calendar2-check"></i>
                        </div>

                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <div class="fw-bold">
                                    {{ $booking->booking_code }}
                                </div>

                                <span class="badge rounded-pill text-bg-primary">
                                    {{ ucwords(
                        str_replace('_', ' ', $booking->status)
                    ) }}
                                </span>
                            </div>

                            <div class="small text-secondary mt-1">
                                Kamar
                                {{ $booking->rooms
                        ->pluck('room_number')
                        ->implode(', ') }}
                                ·
                                {{ $booking->check_in_date->format('d M Y') }}
                                –
                                {{ $booking->check_out_date->format('d M Y') }}
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fw-bold text-primary">
                                Rp {{ number_format(
                        $booking->total_amount,
                        0,
                        ',',
                        '.'
                    ) }}
                            </div>

                            <i class="bi bi-chevron-right text-secondary"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="landing-section" data-aos="zoom-in">
        <div class="cta-section">
            <div>
                <div class="small text-white-50 fw-semibold mb-2">
                    DHYATA HOTEL
                </div>

                <h2 class="fw-bold mb-2">
                    Siap menikmati pengalaman menginap terbaik?
                </h2>

                <p class="text-white-50 mb-0">
                    Buat reservasi sekarang dan dapatkan kamar pilihan Anda.
                </p>
            </div>

            <a href="{{ route('user.bookings.create') }}" class="btn btn-light btn-lg px-4">
                Reservasi Sekarang
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hero-section {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 4rem;
            border-radius: 2rem;
            color: #fff;
            background:
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85') center/cover no-repeat;
            box-shadow: 0 28px 70px rgba(15, 42, 42, .18);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg,
                    rgba(8, 47, 47, .94) 0%,
                    rgba(15, 118, 110, .78) 50%,
                    rgba(15, 118, 110, .20) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 720px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: .55rem .9rem;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
            font-size: .85rem;
            font-weight: 700;
        }

        .hero-content h1 {
            max-width: 680px;
            margin-bottom: 1.25rem;
            font-size: clamp(2.5rem, 6vw, 4.7rem);
            font-weight: 800;
            line-height: 1.05;
        }

        .hero-content h1 span {
            display: block;
            color: #f5c451;
        }

        .hero-content>p {
            max-width: 620px;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, .78);
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .hero-stats div {
            display: grid;
            gap: .15rem;
        }

        .hero-stats strong {
            font-size: 1.6rem;
        }

        .hero-stats span {
            color: rgba(255, 255, 255, .65);
            font-size: .82rem;
        }

        .quick-booking {
            position: relative;
            z-index: 5;
            margin: -42px 2rem 0;
        }

        .quick-booking-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            padding: 1.6rem;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.5rem;
            background: var(--bs-body-bg);
            box-shadow: 0 20px 55px rgba(15, 42, 42, .14);
        }

        .landing-section {
            padding-top: 5.5rem;
        }

        .section-kicker {
            margin-bottom: .45rem;
            color: #0f766e;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 1rem;
        }

        .room-card {
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.5rem;
            background: var(--bs-body-bg);
            box-shadow: 0 18px 45px rgba(15, 42, 42, .08);
            transition:
                transform .22s ease,
                box-shadow .22s ease;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 55px rgba(15, 42, 42, .13);
        }

        .room-image {
            position: relative;
            height: 235px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
        }

        .room-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .room-card:hover .room-image img {
            transform: scale(1.04);
        }

        .availability-badge,
        .room-number {
            position: absolute;
            top: 1rem;
            padding: .45rem .7rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
        }

        .availability-badge {
            left: 1rem;
            color: #fff;
            background: rgba(15, 118, 110, .88);
        }

        .room-number {
            right: 1rem;
            color: #fff;
            background: rgba(15, 23, 42, .65);
        }

        .room-body {
            padding: 1.4rem;
        }

        .room-capacity {
            display: flex;
            align-items: center;
            gap: .35rem;
            padding: .5rem .7rem;
            border-radius: .75rem;
            color: #0f766e;
            background: rgba(13, 148, 136, .10);
            font-weight: 700;
        }

        .room-description {
            min-height: 42px;
        }

        .room-footer {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 1rem;
            padding-top: 1.2rem;
            margin-top: 1.2rem;
            border-top: 1px solid rgba(148, 163, 184, .14);
        }

        .room-price {
            color: #0f766e;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .facility-card {
            padding: 1.6rem;
            border: 1px solid rgba(148, 163, 184, .14);
            border-radius: 1.35rem;
            background: var(--bs-body-bg);
            text-align: center;
        }

        .facility-icon,
        .process-icon {
            width: 64px;
            height: 64px;
            display: grid;
            place-items: center;
            margin: 0 auto 1.15rem;
            border-radius: 1.25rem;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #d4a017);
            font-size: 1.5rem;
        }

        .process-section {
            padding: 3rem;
            border-radius: 2rem;
            background: var(--bs-tertiary-bg);
        }

        .process-card {
            position: relative;
            height: 100%;
            padding: 1.5rem;
            border-radius: 1.35rem;
            background: var(--bs-body-bg);
            text-align: center;
        }

        .process-number {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #0f766e;
            background: rgba(13, 148, 136, .12);
            font-weight: 800;
        }

        .recent-bookings {
            display: grid;
            gap: .75rem;
        }

        .recent-booking-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.1rem;
            border: 1px solid rgba(148, 163, 184, .14);
            border-radius: 1.1rem;
            color: inherit;
            background: var(--bs-body-bg);
            text-decoration: none;
            transition: background .2s ease;
        }

        .recent-booking-item:hover {
            color: inherit;
            background: rgba(13, 148, 136, .05);
        }

        .booking-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #0f766e;
            background: rgba(13, 148, 136, .10);
            font-size: 1.2rem;
        }

        .cta-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            padding: 3rem;
            border-radius: 2rem;
            color: #fff;
            background:
                linear-gradient(135deg, #102a2a, #0f766e);
            box-shadow: 0 22px 55px rgba(15, 118, 110, .20);
        }

        .empty-state {
            padding: 4rem 1.5rem;
            border: 1px dashed rgba(148, 163, 184, .35);
            border-radius: 1.5rem;
            text-align: center;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            margin: 0 auto 1rem;
            border-radius: 1.4rem;
            color: #0f766e;
            background: rgba(13, 148, 136, .10);
            font-size: 1.8rem;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                min-height: 520px;
                padding: 3rem 2rem;
            }

            .hero-overlay {
                background: rgba(8, 47, 47, .84);
            }

            .quick-booking {
                margin: 1.5rem 0 0;
            }

            .quick-booking-card,
            .cta-section {
                align-items: stretch;
                flex-direction: column;
            }

            .quick-booking-card .btn,
            .cta-section .btn {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .hero-section {
                min-height: 580px;
                padding: 2rem 1.25rem;
                border-radius: 1.4rem;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            .landing-section {
                padding-top: 4rem;
            }

            .section-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .section-heading .btn {
                width: 100%;
            }

            .process-section,
            .cta-section {
                padding: 1.5rem;
                border-radius: 1.4rem;
            }

            .recent-booking-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .recent-booking-item>.text-end {
                width: 100%;
                padding-left: 4rem;
                text-align: left !important;
            }
        }
    </style>
@endpush