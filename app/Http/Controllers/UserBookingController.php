<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserBookingController extends Controller
{
    public function home(Request $request)
    {
        $availableRooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        $recentBookings = collect();

        if ($request->user()?->role === 'user') {
            $recentBookings = Booking::with([
                'rooms.roomType',
                'guest',
            ])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('user.home', compact(
            'availableRooms',
            'recentBookings'
        ));
    }

    public function index(Request $request)
    {
        $items = Booking::with([
            'rooms.roomType',
            'guest',
        ])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('items'));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        if (
            !$user->identity_number ||
            !$user->phone ||
            !$user->gender ||
            !$user->address
        ) {
            return redirect()
                ->route('user.profile.edit')
                ->with(
                    'warning',
                    'Lengkapi profil terlebih dahulu sebelum membuat reservasi.'
                );
        }

        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view('user.bookings.create', compact(
            'rooms',
            'user'
        ));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (
            !$user->identity_number ||
            !$user->phone ||
            !$user->gender ||
            !$user->address
        ) {
            return redirect()
                ->route('user.profile.edit')
                ->with(
                    'warning',
                    'Lengkapi profil terlebih dahulu sebelum membuat reservasi.'
                );
        }

        $data = $request->validate([
            'check_in_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'check_out_date' => [
                'required',
                'date',
                'after:check_in_date',
            ],
            'room_ids' => [
                'required',
                'array',
                'min:1',
            ],
            'room_ids.*' => [
                'required',
                'exists:rooms,id',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $booking = DB::transaction(function () use ($data, $user) {
            $guest = Guest::updateOrCreate(
                [
                    'identity_number' => $user->identity_number,
                ],
                [
                    'name' => $user->name,
                    'gender' => $user->gender,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $user->address,
                ]
            );

            $nights = max(
                1,
                Carbon::parse($data['check_in_date'])
                    ->diffInDays(
                        Carbon::parse($data['check_out_date'])
                    )
            );

            $rooms = Room::with('roomType')
                ->where('status', 'available')
                ->whereIn('id', $data['room_ids'])
                ->get();

            abort_if(
                $rooms->count() !== count($data['room_ids']),
                422,
                'Salah satu kamar sudah tidak tersedia.'
            );

            $booking = Booking::create([
                'booking_code' => 'ON-' .
                    now()->format('Ymd') .
                    '-' .
                    strtoupper(Str::random(5)),

                'guest_id' => $guest->id,
                'user_id' => $user->id,
                'created_by' => $user->id,
                'booking_source' => 'online',
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'status' => 'booked',

                'total_amount' => $rooms->sum(
                    fn($room) =>
                    $room->roomType->base_price * $nights
                ),

                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($rooms as $room) {
                $price = $room->roomType->base_price;

                $booking->rooms()->attach($room->id, [
                    'price_per_night' => $price,
                    'nights' => $nights,
                    'subtotal' => $price * $nights,
                ]);
            }

            return $booking;
        });

        return redirect()
            ->route('user.bookings.show', $booking)
            ->with(
                'success',
                'Reservasi online berhasil dibuat.'
            );
    }

    public function show(
        Request $request,
        Booking $booking
    ) {
        abort_unless(
            $booking->user_id === $request->user()->id,
            403
        );

        $booking->load([
            'guest',
            'rooms.roomType',
            'creator',
        ]);

        return view('user.bookings.show', compact('booking'));
    }

    public function downloadPdf(
        Request $request,
        Booking $booking
    ) {
        abort_unless(
            $booking->user_id === $request->user()->id,
            403
        );

        $data = $request->validate([
            'qr_image' => [
                'required',
                'string',
            ],
        ]);

        abort_unless(
            str_starts_with(
                $data['qr_image'],
                'data:image/png;base64,'
            ),
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
            'Bukti-Reservasi-' .
            $booking->booking_code .
            '.pdf'
        );
    }
}