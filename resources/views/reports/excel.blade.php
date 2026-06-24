<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
        }

        th {
            background: #d1fae5;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Laporan Reservasi Dhiyata Hotel</h2>

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
                    <td>{{ $loop->iteration }}</td>

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
                    <td colspan="12">
                        Tidak ada data reservasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>