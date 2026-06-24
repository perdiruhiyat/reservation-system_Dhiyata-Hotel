@extends('layouts.user')
@section('title','Beranda')
@section('content')
<section class="hero-user mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="hero-pill"><i class="bi bi-stars me-2"></i>Selamat datang, {{ auth()->user()->name }}</span>
            <h1 class="display-5 fw-bold mt-3 mb-3">Temukan kamar nyaman untuk pengalaman menginap terbaik.</h1>
            <p class="lead text-white-50 mb-4">Reservasi kamar dengan mudah, lihat detail pesanan, dan simpan QR code untuk proses check-in.</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('user.bookings.create') }}" class="btn btn-light btn-lg px-4"><i class="bi bi-calendar2-check me-2"></i>Reservasi Sekarang</a>
                <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-light btn-lg px-4"><i class="bi bi-journal-check me-2"></i>Reservasi Saya</a>
            </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
            <div class="hero-glass ms-auto">
                <div class="small text-white-50">Dhiyata Hotel</div>
                <div class="fs-4 fw-bold mb-4">Stay with Comfort</div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="small text-white-50">Kamar tersedia</div>
                            <div class="fs-3 fw-bold">{{ $availableRooms->count() }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="small text-white-50">Reservasi terbaru</div>
                            <div class="fs-3 fw-bold">{{ $recentBookings->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <div class="section-kicker">Kamar Tersedia</div>
        <h2 class="h3 fw-bold mb-1">Pilihan kamar untuk Anda</h2>
        <p class="text-secondary mb-0">Pilih kamar berdasarkan tipe dan kapasitas.</p>
    </div>
    <a href="{{ route('user.bookings.create') }}" class="btn btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
</div>

<div class="row g-4 mb-5">
    @forelse($availableRooms as $room)
    <div class="col-12 col-md-6 col-xl-4">
        <article class="room-card h-100">
            <div class="room-visual">
                <span class="room-no">Kamar {{ $room->room_number }}</span>
                <span class="badge rounded-pill text-bg-success room-status">Tersedia</span>
                <div class="room-card-image">
                    <img
                        src="{{ $room->roomType->image ? asset('storage/images/room-types/' . $room->roomType->image) : asset('images/room-placeholder.jpg') }}"
                        alt="{{ $room->roomType->name }}"
                        class="img-fluid w-100 h-100 object-fit-cover">
                </div>
            </div>
            <div class="p-4">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <div class="small text-secondary">Tipe Kamar</div>
                        <h3 class="h5 fw-bold mb-0">{{ $room->roomType->name }}</h3>
                    </div>
                    <span class="capacity"><i class="bi bi-people me-1"></i>{{ $room->roomType->capacity }}</span>
                </div>
                <p class="small text-secondary">Kamar lantai {{ $room->floor }} untuk {{ $room->roomType->capacity }} orang.</p>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <div class="small text-secondary">Mulai dari</div>
                        <div class="fs-4 fw-bold text-primary">Rp {{ number_format($room->roomType->base_price,0,',','.') }}</div>
                        <div class="small text-secondary">per malam</div>
                    </div>
                    <a href="{{ route('user.bookings.create') }}" class="btn btn-primary">Pilih</a>
                </div>
            </div>
        </article>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state"><i class="bi bi-door-closed fs-1"></i>
            <h3 class="h5 fw-bold mt-3">Belum ada kamar tersedia</h3>
        </div>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <div class="section-kicker">Aktivitas</div>
        <h2 class="h3 fw-bold mb-0">Reservasi terbaru</h2>
    </div>
    <a href="{{ route('user.bookings.index') }}" class="fw-bold text-decoration-none">Lihat semua</a>
</div>

<div class="card border-0 user-panel">
    <div class="card-body p-0">
        @forelse($recentBookings as $booking)
        <a href="{{ route('user.bookings.show',$booking) }}" class="reservation-item text-decoration-none text-body">
            <div class="reservation-icon"><i class="bi bi-calendar2-check"></i></div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between gap-2">
                    <div>
                        <div class="fw-bold">{{ $booking->booking_code }}</div>
                        <div class="small text-secondary">{{ $booking->check_in_date->format('d M Y') }} – {{ $booking->check_out_date->format('d M Y') }}</div>
                    </div><span class="badge text-bg-primary align-self-start">{{ ucwords(str_replace('_',' ',$booking->status)) }}</span>
                </div>
                <div class="small text-secondary mt-2"><i class="bi bi-door-open me-1"></i>Kamar {{ $booking->rooms->pluck('room_number')->join(', ') }}</div>
            </div>
            <i class="bi bi-chevron-right"></i>
        </a>
        @empty
        <div class="empty-state"><i class="bi bi-journal-x fs-1"></i>
            <h3 class="h5 fw-bold mt-3">Belum ada reservasi</h3><a href="{{ route('user.bookings.create') }}" class="btn btn-primary mt-2">Buat Reservasi</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .hero-user {
        padding: 3rem;
        border-radius: 2rem;
        color: #fff;
        background: linear-gradient(135deg, rgba(15, 23, 42, .92), rgba(212, 160, 23, 1)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85') center/cover;
        box-shadow: 0 28px 70px rgba(79, 70, 229, .22)
    }

    .hero-pill {
        display: inline-flex;
        padding: .6rem .9rem;
        border: 1px solid rgba(255, 255, 255, .22);
        border-radius: 999px;
        background: rgba(255, 255, 255, .1)
    }

    .hero-glass {
        max-width: 360px;
        padding: 1.5rem;
        border-radius: 1.5rem;
        background: rgba(255, 255, 255, .11);
        backdrop-filter: blur(18px)
    }

    .mini-stat {
        padding: 1rem;
        border-radius: 1rem;
        background: rgba(255, 255, 255, .1)
    }

    .section-kicker {
        color: var(--bs-primary);
        font-size: .75rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase
    }

    .room-card,
    .user-panel {
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, .16);
        border-radius: 1.5rem;
        background: var(--bs-body-bg);
        box-shadow: 0 18px 45px rgba(15, 23, 42, .07)
    }

    .room-card {
        transition: .25s
    }

    .room-card:hover {
        transform: translateY(-6px)
    }

    .room-visual {
        min-height: 180px;
        position: relative;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, rgba(99, 102, 241, .12), rgba(236, 72, 153, .1))
    }

    .room-icon {
        width: 82px;
        height: 82px;
        display: grid;
        place-items: center;
        border-radius: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #8b5cf6);
        font-size: 2rem
    }

    .room-no,
    .room-status {
        position: absolute;
        top: 1rem
    }

    .room-no {
        left: 1rem;
        padding: .5rem .8rem;
        border-radius: 999px;
        background: var(--bs-body-bg);
        font-size: .8rem;
        font-weight: 800
    }

    .room-status {
        right: 1rem
    }

    .capacity {
        padding: .45rem .7rem;
        border-radius: 999px;
        color: var(--bs-primary);
        background: var(--bs-primary-bg-subtle);
        font-size: .8rem;
        font-weight: 800
    }

    .reservation-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.15rem 1.25rem;
        border-bottom: 1px solid rgba(148, 163, 184, .14)
    }

    .reservation-item:hover {
        background: rgba(99, 102, 241, .05)
    }

    .reservation-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 1rem;
        color: #fff;
        background: linear-gradient(135deg, #0f766e, #0d9488);
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--bs-secondary-color)
    }

    @media(max-width:767px) {
        .hero-user {
            padding: 2rem 1.25rem;
            border-radius: 1.5rem
        }

        .hero-user h1 {
            font-size: 2rem
        }
    }
</style>
@endpush