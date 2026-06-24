<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <title>Bukti Reservasi {{ $booking->booking_code }}</title>

    <style>
        @page {
            margin: 25px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1f2937;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 3px solid #0f766e;
        }

        .brand {
            color: #0f766e;
            font-size: 23px;
            font-weight: bold;
        }

        .subtitle {
            color: #64748b;
        }

        .layout {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin-left: -12px;
        }

        .layout td {
            vertical-align: top;
        }

        .booking-column {
            width: 68%;
        }

        .qr-column {
            width: 32%;
        }

        .card {
            overflow: hidden;
            border: 1px solid #dbe7e5;
            border-radius: 12px;
        }

        .card-header {
            padding: 15px;
            color: #ffffff;
            background: #0f766e;
        }

        .card-body {
            padding: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            width: 50%;
            padding: 7px 0;
        }

        .label {
            margin-bottom: 3px;
            color: #64748b;
            font-size: 10px;
        }

        .value {
            font-weight: bold;
        }

        .section-title {
            padding-top: 14px;
            margin-top: 14px;
            margin-bottom: 10px;
            border-top: 1px dashed #cbd5e1;
            font-size: 14px;
            font-weight: bold;
        }

        .room-table {
            width: 100%;
            border-collapse: collapse;
        }

        .room-table th,
        .room-table td {
            padding: 9px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        .room-table th {
            background: #f1f5f4;
            font-size: 10px;
        }

        .text-right {
            text-align: right !important;
        }

        .total {
            padding: 15px;
            border-top: 1px solid #dbe7e5;
            background: #f0fdfa;
        }

        .total-amount {
            color: #0f766e;
            font-size: 20px;
            font-weight: bold;
        }

        .qr-card {
            padding: 16px;
            border: 1px solid #dbe7e5;
            border-radius: 12px;
            text-align: center;
        }

        .qr-image {
            width: 190px;
            height: 190px;
            margin: 12px auto;
        }

        .booking-code {
            color: #0f766e;
            font-size: 14px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 8px;
            color: #ffffff;
            background: #0f766e;
            border-radius: 20px;
        }

        .notes {
            padding: 10px;
            margin-top: 12px;
            background: #f8fafc;
            border-radius: 8px;
        }

        .footer {
            padding-top: 15px;
            margin-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #64748b;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="brand">Dhiyata Hotel</div>
        <div class="subtitle">Bukti Reservasi Hotel</div>
    </div>

    <table class="layout">
        <tr>
            <td class="booking-column">
                <div class="card">
                    <div class="card-header">
                        <strong>Reservation Confirmation</strong><br>
                        {{ $booking->booking_code }}
                    </div>

                    <div class="card-body">
                        <table class="info-table">
                            <tr>
                                <td>
                                    <div class="label">Nama Tamu</div>
                                    <div class="value">{{ $booking->guest->name }}</div>
                                </td>

                                <td>
                                    <div class="label">Sumber Reservasi</div>
                                    <div class="value">
                                        {{ $booking->booking_source === 'online' ? 'Online' : 'Walk-in' }}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="label">Check-in</div>
                                    <div class="value">
                                        {{ $booking->check_in_date->format('d M Y') }}
                                    </div>
                                </td>

                                <td>
                                    <div class="label">Check-out</div>
                                    <div class="value">
                                        {{ $booking->check_out_date->format('d M Y') }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="section-title">Detail Kamar</div>

                        <table class="room-table">
                            <thead>
                                <tr>
                                    <th>Kamar</th>
                                    <th>Tipe</th>
                                    <th>Malam</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($booking->rooms as $room)
                                    <tr>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->roomType->name }}</td>
                                        <td>{{ $room->pivot->nights }}</td>
                                        <td class="text-right">
                                            Rp {{ number_format($room->pivot->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($booking->notes)
                            <div class="notes">
                                <div class="label">Catatan</div>
                                {{ $booking->notes }}
                            </div>
                        @endif
                    </div>

                    <div class="total">
                        <div class="label">Total Pembayaran</div>

                        <div class="total-amount">
                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </td>

            <td class="qr-column">
                <div class="qr-card">
                    <strong>QR Code Reservasi</strong>

                    <div>
                        <img src="{{ $qrImage }}" alt="QR Code Reservasi" class="qr-image">
                    </div>

                    <div class="booking-code">
                        {{ $booking->booking_code }}
                    </div>

                    <div class="status">
                        {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                    </div>

                    <p>
                        Tunjukkan QR code ini kepada petugas ketika check-in.
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen dibuat otomatis oleh sistem reservasi Dhiyata Hotel.
    </div>
</body>

</html>