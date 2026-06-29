@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<section class="mb-4">
    <div class="card overflow-hidden border-0"
        style="background:linear-gradient(135deg,#0f766e,#0d9488 55%,#d4a017); color:#fff;">
        <div class="card-body p-4 p-lg-5 position-relative">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <div class="text-white-50 fw-semibold mb-2">DHYATA HOTEL MANAGEMENT</div>
                    <h1 class="display-6 fw-bold mb-3">
                        Kelola operasional hotel dengan lebih cepat dan rapi.
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        Pantau reservasi, kamar tersedia, tamu, serta aktivitas check-in dan check-out dari satu dashboard.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('bookings.create') }}" class="btn btn-light px-4">
                            <i class="bi bi-plus-lg me-1"></i> Buat Reservasi
                        </a>

                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-light px-4">
                            <i class="bi bi-door-open me-1"></i> Lihat Kamar
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block text-center">
                    <i class="bi bi-buildings-fill" style="font-size:8rem;opacity:.18"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row g-3 mb-4"> @foreach([ [ 'label' => 'Total Kamar', 'key' => 'rooms', 'icon' => 'bi-door-open-fill', 'background' => 'bg-primary-subtle', 'color' => 'text-primary' ], [ 'label' => 'Kamar Tersedia', 'key' => 'available', 'icon' => 'bi-check-circle-fill', 'background' => 'bg-success-subtle', 'color' => 'text-success' ], [ 'label' => 'Total Tamu', 'key' => 'guests', 'icon' => 'bi-people-fill', 'background' => 'bg-info-subtle', 'color' => 'text-info' ], [ 'label' => 'Reservasi Aktif', 'key' => 'activeBookings', 'icon' => 'bi-calendar2-check-fill', 'background' => 'bg-warning-subtle', 'color' => 'text-warning' ] ] as $stat) <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div>
                        <div class="text-secondary small fw-semibold mb-2"> {{ $stat['label'] }} </div>
                        <div class="display-6 fw-bold"> {{ $stats[$stat['key']] }} </div>
                    </div>
                    <div class="rounded-4 p-3 {{ $stat['background'] }} {{ $stat['color'] }}"> <i class="bi {{ $stat['icon'] }} fs-4"></i> </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-12 col-xl-7">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <div class="text-secondary small fw-semibold">STATISTIK</div>
                        <h2 class="h5 fw-bold mb-0">Reservasi Tahun {{ now()->year }}</h2>
                    </div>

                    <span class="badge rounded-pill text-bg-light border">
                        <i class="bi bi-graph-up-arrow me-1"></i> Data bulanan
                    </span>
                </div>

                <div style="height: 320px;">
                    <canvas
                        id="bookingChart"
                        data-chart-values="{{ $chartData->values()->toJson() }}"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-5">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="text-secondary small fw-semibold">AKTIVITAS</div>
                        <h2 class="h5 fw-bold mb-0">Reservasi Terbaru</h2>
                    </div>

                    <a href="{{ route('bookings.index') }}" class="text-decoration-none fw-bold small">
                        Lihat semua
                    </a>
                </div>

                <div class="vstack gap-3">
                    @forelse($latestBookings as $booking)
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4"
                        style="background:rgba(99,102,241,.05)">
                        <div class="booking-icon rounded-4 d-grid place-items-center flex-shrink-0">
                            <i class="bi bi-calendar2-check"></i>
                        </div>

                        <div class="min-w-0 flex-grow-1">
                            <a href="{{ route('bookings.show',$booking) }}"
                                class="fw-bold text-decoration-none text-body">
                                {{ $booking->booking_code }}
                            </a>
                            <div class="small text-secondary text-truncate">
                                {{ $booking->guest->name }} · Kamar {{ $booking->rooms->pluck('room_number')->join(', ') }}
                            </div>
                        </div>

                        <span class="badge text-bg-{{ $booking->status==='checked_in'?'success':($booking->status==='checked_out'?'secondary':'primary') }}">
                            {{ str_replace('_',' ',$booking->status) }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-secondary"></i>
                        <p class="text-secondary mt-2 mb-0">Belum ada reservasi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts') <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartElement = document.getElementById('bookingChart');
        if (!chartElement || typeof Chart === 'undefined') {
            return;
        }
        const chartValues = JSON.parse(chartElement.dataset.chartValues || '[]');
        new Chart(chartElement, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Reservasi',
                    data: chartValues,
                    borderWidth: 0,
                    borderRadius: 10,
                    backgroundColor: 'rgba(13, 148, 136, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.12)'
                        }
                    }
                }
            }
        });
    });
</script> @endpush