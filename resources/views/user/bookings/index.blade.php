@extends('layouts.user')
@section('title', 'Reservasi Saya')
@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4" data-aos="fade-down">
        <div>
            <div class="section-kicker">Akun Saya</div>
            <h1 class="h2 fw-bold mb-2">Reservasi Saya</h1>
            <p class="text-secondary mb-0">Pantau status dan buka bukti reservasi Anda.</p>
        </div>
        <a href="{{ route('user.bookings.create') }}" class="btn btn-primary btn-lg"><i
                class="bi bi-plus-lg me-2"></i>Reservasi Baru</a>
    </div>
    <div class="row g-4">
        @forelse($items as $booking)
            <div class="col-12 col-xl-6 col-xxl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <article class="booking-card h-100">
                    <div class="booking-top">
                        <div>
                            <div class="small text-secondary">Kode Reservasi</div>
                            <h2 class="h5 fw-bold mb-0">{{ $booking->booking_code }}</h2>
                        </div><span
                            class="badge rounded-pill text-bg-primary">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                    </div>
                    <div class="p-4">
                        <div class="info-grid">
                            <div class="info-item"><i class="bi bi-door-open"></i>
                                <div>
                                    <div class="small text-secondary">Kamar</div>
                                    <div class="fw-semibold">{{ $booking->rooms->pluck('room_number')->join(', ') }}</div>
                                </div>
                            </div>
                            <div class="info-item"><i class="bi bi-calendar-event"></i>
                                <div>
                                    <div class="small text-secondary">Check-in</div>
                                    <div class="fw-semibold">{{ $booking->check_in_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="info-item"><i class="bi bi-calendar-check"></i>
                                <div>
                                    <div class="small text-secondary">Check-out</div>
                                    <div class="fw-semibold">{{ $booking->check_out_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="info-item"><i class="bi bi-wallet2"></i>
                                <div>
                                    <div class="small text-secondary">Total</div>
                                    <div class="fw-bold text-primary">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="booking-footer">
                        <div class="small text-secondary"><i
                                class="bi bi-globe2 me-1"></i>{{ $booking->booking_source === 'online' ? 'Online' : 'Walk-in' }}</div>
                        <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-outline-primary">Lihat Detail <i
                                class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="empty-box"><i class="bi bi-calendar2-x fs-1"></i>
                    <h2 class="h4 fw-bold mt-3">Belum ada reservasi</h2><a href="{{ route('user.bookings.create') }}"
                        class="btn btn-primary mt-2">Buat Reservasi</a>
                </div>
            </div>
        @endforelse
    </div>
    @if($items->hasPages())
    <div class="mt-4" data-aos="fade-up" data-aos-delay="100">{{ $items->links() }}</div>@endif
@endsection
@push('styles')
    <style>
        .section-kicker {
            color: var(--bs-primary);
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase
        }

        .booking-card,
        .empty-box {
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.5rem;
            background: var(--bs-body-bg);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07)
        }

        .booking-card {
            transition: .22s
        }

        .booking-card:hover {
            transform: translateY(-4px)
        }

        .booking-top,
        .booking-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.15rem 1.25rem
        }

        .booking-top {
            border-bottom: 1px solid rgba(148, 163, 184, .14)
        }

        .booking-footer {
            border-top: 1px solid rgba(148, 163, 184, .14);
            background: rgba(13, 148, 136, .04)
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .9rem;
            border-radius: 1rem;
            background: var(--bs-tertiary-bg)
        }

        .info-item>i {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle)
        }

        .empty-box {
            padding: 4rem 1.5rem;
            text-align: center
        }

        @media(max-width:575px) {
            .info-grid {
                grid-template-columns: 1fr
            }

            .booking-footer {
                flex-direction: column;
                align-items: stretch
            }

            .booking-footer .btn {
                width: 100%
            }
        }
    </style>
@endpush