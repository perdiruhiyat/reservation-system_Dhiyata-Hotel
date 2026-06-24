@extends('layouts.user')
@section('title', 'Detail Reservasi')
@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="section-kicker">Bukti Reservasi</div>
            <h1 class="h2 fw-bold mb-1">{{ $booking->booking_code }}</h1>
            <p class="text-secondary mb-0">Tunjukkan QR code saat proses check-in.</p>
        </div>
        <div class="d-flex flex-wrap gap-2 no-print">
            <form method="POST" action="{{ route('user.bookings.pdf', $booking) }}" id="downloadPdfForm">
                @csrf

                <input type="hidden" name="qr_image" id="qrImageInput">

                <button type="submit" class="btn btn-primary" id="downloadPdfButton">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>
                    Download PDF
                </button>
            </form>
            <a href="{{ route('user.bookings.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div id="bookingPdfArea" class="pdf-document">
        <div class="print-heading">
            <div class="fw-bold fs-4">Dhiyata Hotel</div>
            <div class="small">Bukti Reservasi</div>
        </div>
        <div class="row g-4 booking-print-area">
            <div class="col-12 col-xl-8">
                <div class="ticket">
                    <div class="ticket-header">
                        <div>
                            <div class="small text-white-50">Dhiyata Hotel</div>
                            <h2 class="h4 fw-bold mb-0">Reservation Confirmation</h2>
                        </div><span
                            class="badge rounded-pill bg-light text-primary">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                    </div>
                    <div class="ticket-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-label">Nama Tamu</div>
                                <div class="detail-value">{{ $booking->guest->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Sumber Reservasi</div>
                                <div class="detail-value">{{ $booking->booking_source === 'online' ? 'Online' : 'Walk-in' }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-label">Check-in</div>
                                <div class="detail-value">{{ $booking->check_in_date->format('d M Y') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="detail-label">Check-out</div>
                                <div class="detail-value">{{ $booking->check_out_date->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <h3 class="h5 fw-bold mb-3">Detail Kamar</h3>
                        <div class="vstack gap-3">
                            @foreach($booking->rooms as $room)
                                <div class="room-row">
                                    <div class="room-row-icon"><i class="bi bi-door-open"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">Kamar {{ $room->room_number }}</div>
                                        <div class="small text-secondary">{{ $room->roomType->name }} ·
                                            {{ $room->pivot->nights }} malam
                                        </div>
                                    </div>
                                    <div class="fw-bold">Rp {{ number_format($room->pivot->subtotal, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>
                        @if($booking->notes)
                            <div class="notes mt-4">
                                <div class="small text-secondary">Catatan</div>
                                <div>{{ $booking->notes }}</div>
                        </div>@endif
                    </div>
                    <div class="ticket-total">
                        <div>
                            <div class="small text-secondary">Total Pembayaran</div>
                            <div class="fs-3 fw-bold text-primary">Rp
                                {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-secondary">Kode Reservasi</div>
                            <div class="fw-bold">{{ $booking->booking_code }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="qr-card">
                    <div class="qr-icon"><i class="bi bi-qr-code-scan"></i></div>
                    <h2 class="h4 fw-bold mt-3">QR Code Reservasi</h2>
                    <p class="small text-secondary">Tunjukkan QR code ini kepada petugas saat check-in.</p>
                    <div class="qr-wrapper">
                        <div id="reservationQr" data-booking-code="{{ $booking->booking_code }}"
                            data-guest="{{ $booking->guest->name }}"
                            data-check-in="{{ $booking->check_in_date->format('Y-m-d') }}"
                            data-check-out="{{ $booking->check_out_date->format('Y-m-d') }}"
                            data-source="{{ $booking->booking_source }}" data-status="{{ $booking->status }}"></div>
                    </div>
                    <div class="fw-bold mb-3">{{ $booking->booking_code }}</div>
                    <span
                        class="badge rounded-pill text-bg-primary">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
                </div>
            </div>
        </div>
    </div>
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

        .ticket,
        .qr-card {
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.75rem;
            background: var(--bs-body-bg);
            box-shadow: 0 20px 50px rgba(15, 23, 42, .08)
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #0d9488)
        }

        .ticket-body {
            padding: 1.5rem
        }

        .detail-label {
            color: var(--bs-secondary-color);
            font-size: .8rem
        }

        .detail-value {
            font-size: 1.05rem;
            font-weight: 700
        }

        .divider {
            margin: 1.5rem 0;
            border-top: 1px dashed rgba(148, 163, 184, .5)
        }

        .room-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 1rem;
            background: var(--bs-tertiary-bg)
        }

        .room-row-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle)
        }

        .notes {
            padding: 1rem;
            border-radius: 1rem;
            background: var(--bs-tertiary-bg)
        }

        .ticket-total {
            display: flex;
            justify-content: space-between;
            align-items: end;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(148, 163, 184, .14);
            background: rgba(13, 148, 136, .04)
        }

        .qr-card {
            padding: 1.75rem;
            text-align: center
        }

        .qr-icon {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            margin: auto;
            border-radius: 1.25rem;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #d4a017);
            font-size: 1.75rem
        }

        .qr-wrapper {
            display: inline-flex;
            padding: 1rem;
            margin: 1.5rem auto;
            border: 1px solid rgba(148, 163, 184, .18);
            border-radius: 1.25rem;
            background: #fff
        }

        @media(max-width:575px) {

            .ticket-header,
            .ticket-total {
                flex-direction: column;
                align-items: flex-start
            }

            .ticket-total .text-end {
                text-align: left !important
            }
        }


        .pdf-document {
            background: #fff;
            padding: 8px;
            color: #1f2937
        }

        .pdf-document .print-heading {
            display: none
        }

        .pdf-export-mode {
            width: 794px;
            padding: 28px;
            background: #fff
        }

        .pdf-export-mode .print-heading {
            display: block !important;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f766e;
            color: #102a2a
        }

        .pdf-export-mode .booking-print-area {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) 235px;
            gap: 14px !important
        }

        .pdf-export-mode .booking-print-area>.col-12,
        .pdf-export-mode .booking-print-area>.col-xl-8,
        .pdf-export-mode .booking-print-area>.col-xl-4 {
            width: auto !important;
            max-width: none !important;
            padding: 0 !important
        }

        .pdf-export-mode .ticket,
        .pdf-export-mode .qr-card {
            box-shadow: none !important;
            border: 1px solid #d9e4e2 !important;
            border-radius: 14px !important
        }

        .pdf-export-mode .ticket-header {
            background: #0f766e !important;
            color: #fff !important
        }

        .pdf-export-mode .ticket-body {
            padding: 14px !important
        }

        .pdf-export-mode .ticket-total {
            padding: 12px 14px !important
        }

        .pdf-export-mode .room-row {
            padding: 10px !important
        }

        .pdf-export-mode .qr-card {
            padding: 16px !important
        }

        .pdf-export-mode .qr-icon {
            display: none !important
        }

        .pdf-export-mode .qr-wrapper {
            margin: 10px auto !important;
            padding: 8px !important
        }

        .pdf-export-mode .qr-wrapper canvas,
        .pdf-export-mode .qr-wrapper img {
            width: 170px !important;
            height: 170px !important
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            .print-heading {
                display: block !important;
                margin-bottom: 14px;
                padding-bottom: 10px;
                border-bottom: 2px solid #0f766e;
                color: #102a2a;
            }

            .booking-print-area {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) 245px;
                gap: 14px !important;
            }

            .booking-print-area>.col-12,
            .booking-print-area>.col-xl-8,
            .booking-print-area>.col-xl-4 {
                width: auto !important;
                max-width: none !important;
                padding: 0 !important;
            }

            .ticket,
            .qr-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #d9e4e2 !important;
                border-radius: 14px !important;
            }

            .ticket-header {
                color: #fff !important;
                background: #0f766e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .ticket-body {
                padding: 14px !important;
            }

            .ticket-total {
                padding: 12px 14px !important;
            }

            .room-row {
                padding: 10px !important;
            }

            .qr-card {
                padding: 16px !important;
            }

            .qr-icon {
                display: none !important;
            }

            .qr-wrapper {
                margin: 10px auto !important;
                padding: 8px !important;
            }

            .qr-wrapper canvas,
            .qr-wrapper img {
                width: 180px !important;
                height: 180px !important;
            }
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrElement = document.getElementById('reservationQr');
            const pdfForm = document.getElementById('downloadPdfForm');
            const qrInput = document.getElementById('qrImageInput');
            const pdfButton = document.getElementById('downloadPdfButton');

            if (!qrElement || typeof QRCode === 'undefined') {
                return;
            }

            const payload = {
                booking_code: qrElement.dataset.bookingCode,
                guest: qrElement.dataset.guest,
                check_in: qrElement.dataset.checkIn,
                check_out: qrElement.dataset.checkOut,
                source: qrElement.dataset.source,
                status: qrElement.dataset.status
            };

            new QRCode(qrElement, {
                text: JSON.stringify(payload),
                width: 210,
                height: 210,
                correctLevel: QRCode.CorrectLevel.H
            });

            pdfForm?.addEventListener('submit', function (event) {
                event.preventDefault();

                const canvas = qrElement.querySelector('canvas');
                const image = qrElement.querySelector('img');

                let qrDataUrl = '';

                if (canvas) {
                    qrDataUrl = canvas.toDataURL('image/png');
                } else if (image?.src?.startsWith('data:image')) {
                    qrDataUrl = image.src;
                }

                if (!qrDataUrl) {
                    alert('QR Code belum selesai dibuat. Silakan coba kembali.');
                    return;
                }

                qrInput.value = qrDataUrl;

                pdfButton.disabled = true;
                pdfButton.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Membuat PDF...
            `;

                pdfForm.submit();
            });
        });
    </script>
@endpush