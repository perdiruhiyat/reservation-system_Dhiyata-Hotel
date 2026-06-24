<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class UserBookingController extends Controller
{
    public function home(Request $r)
    {
        $availableRooms = Room::with('roomType')->where('status', 'available')->orderBy('room_number')->get();
        $recentBookings = Booking::with(['rooms.roomType', 'guest'])->where('user_id', $r->user()->id)->latest()->take(5)->get();
        return view('user.home', compact('availableRooms', 'recentBookings'));
    }
    public function index(Request $r)
    {
        $items = Booking::with(['rooms.roomType', 'guest'])->where('user_id', $r->user()->id)->latest()->paginate(10);
        return view('user.bookings.index', compact('items'));
    }
    public function create()
    {
        $rooms = Room::with('roomType')->where('status', 'available')->orderBy('room_number')->get();
        return view('user.bookings.create', compact('rooms'));
    }
    public function store(Request $r)
    {
        $d = $r->validate(['identity_number' => 'required|max:50', 'phone' => 'required|max:25', 'gender' => 'required|in:L,P', 'address' => 'nullable', 'check_in_date' => 'required|date|after_or_equal:today', 'check_out_date' => 'required|date|after:check_in_date', 'room_ids' => 'required|array|min:1', 'room_ids.*' => 'exists:rooms,id', 'notes' => 'nullable|max:1000']);
        $b = DB::transaction(function () use ($d, $r) {
            $g = Guest::updateOrCreate(['identity_number' => $d['identity_number']], ['name' => $r->user()->name, 'gender' => $d['gender'], 'phone' => $d['phone'], 'email' => $r->user()->email, 'address' => $d['address'] ?? null]);
            $n = max(1, Carbon::parse($d['check_in_date'])->diffInDays(Carbon::parse($d['check_out_date'])));
            $rooms = Room::with('roomType')->where('status', 'available')->whereIn('id', $d['room_ids'])->get();
            abort_if($rooms->count() !== count($d['room_ids']), 422, 'Salah satu kamar sudah tidak tersedia.');
            $b = Booking::create(['booking_code' => 'ON-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)), 'guest_id' => $g->id, 'user_id' => $r->user()->id, 'created_by' => $r->user()->id, 'booking_source' => 'online', 'check_in_date' => $d['check_in_date'], 'check_out_date' => $d['check_out_date'], 'status' => 'booked', 'total_amount' => $rooms->sum(fn($x) => $x->roomType->base_price * $n), 'notes' => $d['notes'] ?? null]);
            foreach ($rooms as $x) {
                $p = $x->roomType->base_price;
                $b->rooms()->attach($x->id, ['price_per_night' => $p, 'nights' => $n, 'subtotal' => $p * $n]);
            }
            return $b;
        });
        return redirect()->route('user.bookings.show', $b)->with('success', 'Reservasi online berhasil dibuat.');
    }
    public function show(Request $r, Booking $booking)
    {
        abort_unless($booking->user_id === $r->user()->id, 403);
        $booking->load(['guest', 'rooms.roomType', 'creator']);
        return view('user.bookings.show', compact('booking'));
    }
    public function downloadPdf(Request $r, Booking $booking)
    {
        abort_unless($booking->user_id === $r->user()->id, 403);

        $data = $r->validate([
            'qr_image' => ['required', 'string'],
        ]);

        abort_unless(
            str_starts_with($data['qr_image'], 'data:image/png;base64,'),
            422,
            'Format QR Code tidak valid.'
        );

        $booking->load([
            'guest',
            'rooms.roomType',
            'creator',
        ]);

        $pdf = Pdf::loadView('user.bookings.pdf', [
            'booking' => $booking,
            'qrImage' => $data['qr_image'],
        ])->setPaper('a4', 'portrait');

        return $pdf->download(
            'Bukti-Reservasi-' . $booking->booking_code . '.pdf'
        );
    }

}
