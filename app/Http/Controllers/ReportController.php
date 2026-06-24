<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->paginate(15)
            ->withQueryString();

        return view('reports.reservations', compact('items'));
    }

    public function exportCsv()
    {
        $fileName = 'laporan-reservasi.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 supaya Excel bisa membaca karakter Indonesia
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'ID',
                'Kode Reservasi',
                'Nama Tamu',
                'Email',
                'Telepon',
                'Nomor Kamar',
                'Tipe Kamar',
                'Check-In',
                'Check-Out',
                'Sumber',
                'Status',
                'Total Pembayaran',
            ]);

            $bookings = Booking::with([
                'guest',
                'rooms.roomType',
            ])->get();

            foreach ($bookings as $booking) {
                $nomorKamar = $booking->rooms
                    ->pluck('room_number')
                    ->implode(', ');

                $tipeKamar = $booking->rooms
                    ->map(function ($room) {
                        return $room->roomType->name ?? '-';
                    })
                    ->unique()
                    ->implode(', ');

                fputcsv($file, [
                    $booking->id,
                    $booking->booking_code,
                    $booking->guest->name ?? '-',
                    $booking->guest->email ?? '-',
                    $booking->guest->phone ?? '-',
                    $nomorKamar ?: '-',
                    $tipeKamar ?: '-',
                    $booking->check_in_date
                    ? $booking->check_in_date->format('d-m-Y')
                    : '-',
                    $booking->check_out_date
                    ? $booking->check_out_date->format('d-m-Y')
                    : '-',
                    $booking->booking_source === 'online'
                    ? 'Online'
                    : 'Walk-in',
                    ucwords(str_replace('_', ' ', $booking->status)),
                    $booking->total_amount,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
    {
        $bookings = Booking::with([
            'guest',
            'rooms.roomType',
        ])->get();

        return view('reports.print', compact('bookings'));
    }

    public function printExcel()
    {
        $bookings = Booking::with([
            'guest',
            'rooms.roomType',
        ])->get();

        return response()
            ->view('reports.excel', compact('bookings'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header(
                'Content-Disposition',
                'attachment; filename="laporan-reservasi.xls"'
            );
    }


    private function filteredQuery(Request $request)
    {
        return Booking::with(['guest', 'rooms'])
            ->when(
                $request->filled('from'),
                fn($query) => $query->whereDate('check_in_date', '>=', $request->from)
            )
            ->when(
                $request->filled('to'),
                fn($query) => $query->whereDate('check_out_date', '<=', $request->to)
            )
            ->latest();
    }
}
