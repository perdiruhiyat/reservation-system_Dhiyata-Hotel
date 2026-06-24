@extends('layouts.app')
@section('title', 'Reservasi')
@section('content')
    <x-page-header title="Reservasi" subtitle="Kelola booking, check-in, dan check-out tamu.">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
            <i class="bi bi-qr-code-scan me-1"></i>
            Scan QR Check-In
        </button>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Buat Reservasi</a>
    </x-page-header>

    <div class="card">
        <div class="card-body">
            <form class="row g-2 mb-3">
                <div class="col-12 col-md-5"><input name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari kode atau nama tamu..."></div>
                <div class="col-8 col-md-3"><select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach(['booked', 'checked_in', 'checked_out', 'cancelled'] as $s)<option value="{{ $s }}"
                        @selected(request('status') === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>@endforeach
                    </select></div>
                <div class="col-4 col-md-auto"><button class="btn btn-outline-primary w-100">Filter</button></div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)<tr>
                            <td><a href="{{ route('bookings.show', $item) }}"
                                    class="fw-semibold text-decoration-none">{{ $item->booking_code }}</a></td>
                            <td>{{ $item->guest->name }}</td>
                            <td>{{ $item->rooms->pluck('room_number')->join(', ') }}</td>
                            <td>{{ $item->check_in_date->format('d M Y') }}<br><small class="text-secondary">s.d.
                                    {{ $item->check_out_date->format('d M Y') }}</small></td>
                            <td><span
                                    class="badge text-bg-{{ $item->status === 'checked_in' ? 'success' : ($item->status === 'checked_out' ? 'secondary' : 'primary') }}">{{ str_replace('_', ' ', $item->status) }}</span>
                            </td>
                            <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('bookings.show', $item) }}" class="btn btn-sm btn-outline-secondary"><i
                                        class="bi bi-eye"></i></a>
                                @if($item->status === 'booked')<a href="{{ route('bookings.edit', $item) }}"
                                        class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('bookings.check-in', $item) }}" class="d-inline">@csrf
                                @method('PATCH')<button class="btn btn-sm btn-success">Check-in</button></form>@endif
                                @if($item->status === 'checked_in')
                                    <form method="POST" action="{{ route('bookings.check-out', $item) }}" class="d-inline">@csrf
                                @method('PATCH')<button class="btn btn-sm btn-warning">Check-out</button></form>@endif
                                @if(auth()->user()->role === 'admin' && $item->status !== 'checked_in')
                                    <form method="POST" action="{{ route('bookings.destroy', $item) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus reservasi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>@empty<tr>
                            <td colspan="7" class="text-center text-secondary py-4">Belum ada reservasi.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>{{ $items->links() }}
        </div>
    </div>
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold" id="qrScannerModalLabel">Scan QR Check-In</h5>
                        <div class="small text-secondary">Arahkan kamera ke QR Code reservasi online.</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div id="qrReader"></div>
                    <div id="scanStatus" class="alert d-none mt-3 mb-0" role="alert"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="restartScannerButton">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Scan Ulang
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
<style>
    #qrScannerModal {
        z-index: 1080;
    }

    #qrScannerModal .modal-dialog {
        position: relative;
        z-index: 1081;
    }

    #qrScannerModal .modal-content {
        overflow: hidden;
        border-radius: 1rem;
    }

    #qrScannerModal .modal-header,
    #qrScannerModal .modal-footer {
        position: relative;
        z-index: 5;
        background: var(--bs-body-bg);
    }

    #qrScannerModal .modal-body {
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    #qrReader {
        position: relative;
        width: 100%;
        overflow: hidden;
        border: 0 !important;
    }

    #qrReader video,
    #qrReader canvas {
        position: relative !important;
        width: 100% !important;
        max-height: 380px;
        object-fit: cover;
        border-radius: 12px;
    }

    .modal-backdrop {
        z-index: 1070 !important;
    }

    #sideBackdrop,
    .offcanvas-backdrop {
        z-index: 1035 !important;
    }

    body.modal-open #sideBackdrop,
    body.modal-open .offcanvas-backdrop {
        pointer-events: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('qrScannerModal');
    const statusElement = document.getElementById('scanStatus');
    const restartButton = document.getElementById('restartScannerButton');

    if (!modalElement) {
        return;
    }

    // Pindahkan modal langsung ke body agar tidak tertutup backdrop/layout.
    document.body.appendChild(modalElement);

    let scanner = null;
    let isProcessing = false;
    let isStopping = false;

    function showStatus(type, message) {
        statusElement.className = `alert alert-${type} mt-3 mb-0`;
        statusElement.textContent = message;
    }

    function clearStatus() {
        statusElement.className = 'alert d-none mt-3 mb-0';
        statusElement.textContent = '';
    }

    async function stopScanner() {
        if (!scanner || isStopping) {
            return;
        }

        isStopping = true;

        try {
            await scanner.stop();
        } catch (error) {
            console.warn('Scanner belum aktif atau sudah berhenti.', error);
        }

        try {
            scanner.clear();
        } catch (error) {
            console.warn('Scanner tidak dapat dibersihkan.', error);
        }

        scanner = null;
        isStopping = false;
    }

    async function startScanner() {
        clearStatus();
        isProcessing = false;

        await stopScanner();

        const reader = document.getElementById('qrReader');

        if (reader) {
            reader.innerHTML = '';
        }

        scanner = new Html5Qrcode('qrReader');

        try {
            await scanner.start(
                {
                    facingMode: 'environment'
                },
                {
                    fps: 10,
                    qrbox: {
                        width: 240,
                        height: 240
                    },
                    aspectRatio: 1
                },
                async function (decodedText) {
                    if (isProcessing) {
                        return;
                    }

                    isProcessing = true;

                    showStatus(
                        'info',
                        'QR berhasil dibaca. Memproses check-in...'
                    );

                    await stopScanner();

                    try {
                        const csrfToken = document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content');

                        if (!csrfToken) {
                            throw new Error(
                                'CSRF token tidak ditemukan pada layout.'
                            );
                        }

                        const response = await fetch(
                            "{{ route('bookings.scan-check-in') }}",
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    qr_data: decodedText
                                })
                            }
                        );

                        const result = await response.json();

                        if (!response.ok || !result.success) {
                            throw new Error(
                                result.message ||
                                'Check-in gagal diproses.'
                            );
                        }

                        showStatus(
                            'success',
                            `${result.message} Tamu: ${result.booking.guest_name}. Kamar: ${result.booking.rooms}.`
                        );

                        setTimeout(function () {
                            window.location.href =
                                result.booking.detail_url;
                        }, 1200);
                    } catch (error) {
                        showStatus('danger', error.message);
                        isProcessing = false;
                    }
                },
                function () {
                    // Abaikan error pembacaan setiap frame.
                }
            );
        } catch (error) {
            console.error(error);

            showStatus(
                'danger',
                'Kamera tidak dapat dibuka. Pastikan izin kamera diberikan dan halaman dibuka melalui localhost atau HTTPS.'
            );
        }
    }

    modalElement.addEventListener('shown.bs.modal', function () {
        startScanner();
    });

    modalElement.addEventListener('hide.bs.modal', function () {
        stopScanner();
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        clearStatus();
        isProcessing = false;

        const reader = document.getElementById('qrReader');

        if (reader) {
            reader.innerHTML = '';
        }

        document
            .querySelectorAll('.modal-backdrop')
            .forEach(function (backdrop) {
                backdrop.remove();
            });

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    });

    restartButton?.addEventListener('click', function () {
        startScanner();
    });
});
</script>
@endpush