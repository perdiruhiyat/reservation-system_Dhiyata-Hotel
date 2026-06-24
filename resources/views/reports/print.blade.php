<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Print Laporan Reservasi</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1f2937;
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            margin-bottom: 18px;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 4px;
            color: #0f766e;
            font-size: 22px;
        }

        .header p {
            margin: 0;
            color: #64748b;
        }

        .toolbar {
            margin-bottom: 16px;
            text-align: right;
        }

        .toolbar button {
            padding: 9px 16px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: #0f766e;
            cursor: pointer;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 7px;
            border: 1px solid #94a3b8;
            vertical-align: top;
        }

        th {
            color: #fff;
            background: #0f766e;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f0fdfa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 18px;
            color: #64748b;
            font-size: 10px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 10px;
            }

            th {
                color: #000;
                background: #d1fae5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tbody tr:nth-child(even) {
                background: #f0fdfa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Dhiyata Hotel</h1>
        <p>Laporan Data Reservasi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Reservasi</th>
                <th>Nama Tamu</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Nomor Kamar</th>
                <th>Tipe Kamar</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Sumber</th>
                <th>Status</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>

                    <td>{{ $booking->booking_code }}</td>

                    <td>{{ $booking->guest->name ?? '-' }}</td>

                    <td>{{ $booking->guest->email ?? '-' }}</td>

                    <td>{{ $booking->guest->phone ?? '-' }}</td>

                    <td>
                        {{ $booking->rooms->pluck('room_number')->implode(', ') ?: '-' }}
                    </td>

                    <td>
                        {{ $booking->rooms
                            ->map(fn ($room) => $room->roomType->name ?? '-')
                            ->unique()
                            ->implode(', ') ?: '-' }}
                    </td>

                    <td>
                        {{ $booking->check_in_date
                            ? $booking->check_in_date->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        {{ $booking->check_out_date
                            ? $booking->check_out_date->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        {{ $booking->booking_source === 'online'
                            ? 'Online'
                            : 'Walk-in' }}
                    </td>

                    <td>
                        {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        Tidak ada data reservasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>