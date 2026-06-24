<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'rooms' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'guests' => Guest::count(),
            'activeBookings' => Booking::whereIn('status', ['booked', 'checked_in'])->count(),
        ];

        $monthly = Booking::selectRaw('MONTH(created_at) month, COUNT(*) total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')->pluck('total', 'month');

        $chartData = collect(range(1, 12))->map(fn($m) => $monthly[$m] ?? 0);

        $latestBookings = Booking::with(['guest', 'rooms'])->latest()->take(6)->get();

        return view('dashboard', compact('stats', 'chartData', 'latestBookings'));
    }
}
