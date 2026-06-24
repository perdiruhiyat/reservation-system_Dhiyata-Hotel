<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $r)
    {
        $items = Booking::with(['guest', 'rooms'])->when($r->search, fn($q, $s) => $q->where('booking_code', 'like', "%$s%")->orWhereHas('guest', fn($g) => $g->where('name', 'like', "%$s%")))->when($r->status, fn($q, $s) => $q->where('status', $s))->latest()->paginate(10)->withQueryString();
        return view('bookings.index', compact('items'));
    }
    public function create()
    {
        return view('bookings.form', ['item' => new Booking, 'guests' => Guest::orderBy('name')->get(), 'rooms' => Room::with('roomType')->where('status', 'available')->orderBy('room_number')->get(), 'selectedRooms' => []]);
    }
    public function store(Request $r)
    {
        $d = $this->validated($r);
        DB::transaction(function () use ($d, $r) {
            $g = $d['guest_mode'] === 'new' ? Guest::create(['identity_number' => $d['new_identity_number'], 'name' => $d['new_name'], 'gender' => $d['new_gender'], 'phone' => $d['new_phone'], 'email' => $d['new_email'] ?? null, 'address' => $d['new_address'] ?? null]) : Guest::findOrFail($d['guest_id']);
            $n = max(1, Carbon::parse($d['check_in_date'])->diffInDays(Carbon::parse($d['check_out_date'])));
            $rooms = Room::with('roomType')->where('status', 'available')->whereIn('id', $d['room_ids'])->get();
            abort_if($rooms->count() !== count($d['room_ids']), 422, 'Salah satu kamar sudah tidak tersedia.');
            $b = Booking::create(['booking_code' => 'WI-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)), 'guest_id' => $g->id, 'user_id' => null, 'created_by' => $r->user()->id, 'booking_source' => 'walk_in', 'check_in_date' => $d['check_in_date'], 'check_out_date' => $d['check_out_date'], 'status' => 'booked', 'total_amount' => $rooms->sum(fn($x) => $x->roomType->base_price * $n), 'notes' => $d['notes'] ?? null]);
            foreach ($rooms as $x) {
                $p = $x->roomType->base_price;
                $b->rooms()->attach($x->id, ['price_per_night' => $p, 'nights' => $n, 'subtotal' => $p * $n]);
            }
        });
        return redirect()->route('bookings.index')->with('success', 'Reservasi walk-in berhasil dibuat.');
    }
    public function show(Booking $booking)
    {
        $booking->load(['guest', 'rooms.roomType', 'creator', 'user']);
        return view('bookings.show', compact('booking'));
    }
    public function edit(Booking $booking)
    {
        abort_if(in_array($booking->status, ['checked_in', 'checked_out']), 422);
        $booking->load('rooms');
        return view('bookings.form', ['item' => $booking, 'guests' => Guest::orderBy('name')->get(), 'rooms' => Room::with('roomType')->where(fn($q) => $q->where('status', 'available')->orWhereIn('id', $booking->rooms->pluck('id')))->get(), 'selectedRooms' => $booking->rooms->pluck('id')->all()]);
    }
    public function update(Request $r, Booking $booking)
    {
        abort_if(in_array($booking->status, ['checked_in', 'checked_out']), 422);
        $d = $r->validate(['guest_id' => 'required|exists:guests,id', 'check_in_date' => 'required|date', 'check_out_date' => 'required|date|after:check_in_date', 'room_ids' => 'required|array|min:1', 'room_ids.*' => 'exists:rooms,id', 'notes' => 'nullable|max:1000']);
        DB::transaction(function () use ($d, $booking) {
            $n = max(1, Carbon::parse($d['check_in_date'])->diffInDays(Carbon::parse($d['check_out_date'])));
            $rooms = Room::with('roomType')->whereIn('id', $d['room_ids'])->get();
            $booking->update(['guest_id' => $d['guest_id'], 'check_in_date' => $d['check_in_date'], 'check_out_date' => $d['check_out_date'], 'notes' => $d['notes'] ?? null, 'total_amount' => $rooms->sum(fn($x) => $x->roomType->base_price * $n)]);
            $sync = [];
            foreach ($rooms as $x) {
                $p = $x->roomType->base_price;
                $sync[$x->id] = ['price_per_night' => $p, 'nights' => $n, 'subtotal' => $p * $n];
            }
            $booking->rooms()->sync($sync);
        });
        return redirect()->route('bookings.index')->with('success', 'Reservasi diperbarui.');
    }
    public function destroy(Booking $booking)
    {
        abort_if($booking->status === 'checked_in', 422, 'Tamu masih check-in.');
        $booking->delete();
        return back()->with('success', 'Reservasi dihapus.');
    }
    public function checkIn(Booking $booking)
    {
        abort_unless($booking->status === 'booked', 422);
        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'checked_in', 'actual_check_in' => now()]);
            $booking->rooms()->update(['status' => 'occupied']);
        });
        return back()->with('success', 'Check-in berhasil.');
    }
    public function checkOut(Booking $booking)
    {
        abort_unless($booking->status === 'checked_in', 422);
        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'checked_out', 'actual_check_out' => now()]);
            $booking->rooms()->update(['status' => 'available']);
        });
        return back()->with('success', 'Check-out berhasil.');
    }
    private function validated(Request $r): array
    {
        return $r->validate(['guest_mode' => ['required', Rule::in(['existing', 'new'])], 'guest_id' => ['nullable', 'required_if:guest_mode,existing', 'exists:guests,id'], 'new_identity_number' => ['nullable', 'required_if:guest_mode,new', 'max:50', 'unique:guests,identity_number'], 'new_name' => ['nullable', 'required_if:guest_mode,new', 'max:120'], 'new_gender' => ['nullable', 'required_if:guest_mode,new', Rule::in(['L', 'P'])], 'new_phone' => ['nullable', 'required_if:guest_mode,new', 'max:25'], 'new_email' => ['nullable', 'email'], 'new_address' => ['nullable'], 'check_in_date' => 'required|date', 'check_out_date' => 'required|date|after:check_in_date', 'room_ids' => 'required|array|min:1', 'room_ids.*' => 'exists:rooms,id', 'notes' => 'nullable|max:1000']);
    }

    public function scanCheckIn(Request $request)
    {
        $data = $request->validate(['qr_data' => ['required', 'string', 'max:3000'],]);
        try { /* * QR sebelumnya berisi JSON: * { * "booking_code": "ON-20260624-ABCDE", * "guest": "...", * ... * } * * Method ini juga mendukung QR yang hanya berisi booking code. */
            $decoded = json_decode($data['qr_data'], true);
            $bookingCode = is_array($decoded) ? ($decoded['booking_code'] ?? null) : trim($data['qr_data']);
            if (!$bookingCode) {
                return response()->json(['success' => false, 'message' => 'QR Code tidak memiliki kode reservasi.',], 422);
            }
            $booking = Booking::with(['guest', 'rooms.roomType',])->where('booking_code', $bookingCode)->first();
            if (!$booking) {
                return response()->json(['success' => false, 'message' => 'Data reservasi tidak ditemukan.',], 404);
            }
            if ($booking->booking_source !== 'online') {
                return response()->json(['success' => false, 'message' => 'QR hanya dapat digunakan untuk reservasi online.',], 422);
            }
            if ($booking->status === 'checked_in') {
                return response()->json(['success' => false, 'message' => 'Tamu ini sudah melakukan check-in.',], 422);
            }
            if ($booking->status === 'checked_out') {
                return response()->json(['success' => false, 'message' => 'Reservasi ini sudah selesai check-out.',], 422);
            }
            if (in_array($booking->status, ['cancelled', 'canceled'], true)) {
                return response()->json(['success' => false, 'message' => 'Reservasi ini sudah dibatalkan.',], 422);
            }
            if ($booking->status !== 'booked') {
                return response()->json(['success' => false, 'message' => 'Status reservasi tidak dapat diproses untuk check-in.',], 422);
            }
            DB::transaction(function () use ($booking) {
                $booking->update(['status' => 'checked_in',]);
                Room::whereIn('id', $booking->rooms->pluck('id'))->update(['status' => 'occupied',]); });
            return response()->json(['success' => true, 'message' => 'Check-in berhasil diproses.', 'booking' => ['id' => $booking->id, 'booking_code' => $booking->booking_code, 'guest_name' => $booking->guest->name ?? '-', 'rooms' => $booking->rooms->pluck('room_number')->implode(', '), 'status' => 'checked_in', 'detail_url' => route('bookings.show', $booking),],]);
        } catch (\Throwable $e) {
            Log::error('QR check-in gagal', ['message' => $e->getMessage(), 'qr_data' => $data['qr_data'] ?? null,]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memproses QR Code.',], 500);
        }
    }
}
