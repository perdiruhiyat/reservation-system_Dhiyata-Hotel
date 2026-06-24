@extends('layouts.app')
@section('title','Detail Reservasi')
@section('content')
<x-page-header title="Detail Reservasi" subtitle="Informasi lengkap dan QR code reservasi."><a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <div class="small text-secondary">Kode Booking</div>
                        <h2 class="h4 fw-bold">{{ $booking->booking_code }}</h2>
                    </div>
                    <div><span class="badge text-bg-light border">{{ $booking->booking_source==='online'?'Online':'Walk-in' }}</span> <span class="badge text-bg-primary">{{ str_replace('_',' ',$booking->status) }}</span></div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="small text-secondary">Tamu</div><strong>{{ $booking->guest->name }}</strong>
                    </div>
                    <div class="col-6">
                        <div class="small text-secondary">Dibuat Oleh</div><strong>{{ $booking->creator->name }}</strong>
                    </div>
                    <div class="col-6">
                        <div class="small text-secondary">Check-in</div><strong>{{ $booking->check_in_date->format('d M Y') }}</strong>
                    </div>
                    <div class="col-6">
                        <div class="small text-secondary">Check-out</div><strong>{{ $booking->check_out_date->format('d M Y') }}</strong>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kamar</th>
                                <th>Tipe</th>
                                <th>Malam</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>@foreach($booking->rooms as $room)<tr>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ $room->roomType->name }}</td>
                                <td>{{ $room->pivot->nights }}</td>
                                <td>Rp {{ number_format($room->pivot->subtotal,0,',','.') }}</td>
                            </tr>@endforeach</tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between border-top pt-3"><strong>Total</strong><span class="fs-4 fw-bold text-primary">Rp {{ number_format($booking->total_amount,0,',','.') }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="h5 fw-bold">QR Code Reservasi</h3>
                <p class="small text-secondary">Pindai untuk membaca informasi reservasi.</p>
                <div id="reservationQr" class="d-flex justify-content-center my-4"></div>
                <div class="small text-secondary">{{ $booking->booking_code }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
    const qrElement = document.getElementById('reservationQr');

    if (qrElement) {
        const qrData = {
            booking_code: qrElement.dataset.bookingCode,
            guest: qrElement.dataset.guest,
            check_in: qrElement.dataset.checkIn,
            check_out: qrElement.dataset.checkOut,
            source: qrElement.dataset.source,
            status: qrElement.dataset.status
        };

        new QRCode(qrElement, {
            text: JSON.stringify(qrData),
            width: 210,
            height: 210,
            correctLevel: QRCode.CorrectLevel.H
        });
    }
</script>
@endpush