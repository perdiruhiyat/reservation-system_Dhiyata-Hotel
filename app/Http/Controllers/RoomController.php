<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $r)
    {
        $items = Room::with('roomType')->when($r->search, fn($q, $s) => $q->where('room_number', 'like', "%$s%"))->latest()->paginate(10)->withQueryString();
        return view('rooms.index', compact('items'));
    }
    public function create()
    {
        return view('rooms.form', ['item' => new Room, 'types' => RoomType::all(), 'facilities' => Facility::all(), 'selected' => []]);
    }
    public function store(Request $r)
    {
        $room = Room::create($this->validated($r));
        $room->facilities()->sync($r->input('facility_ids', []));
        return redirect()->route('rooms.index')->with('success', 'Kamar ditambahkan.');
    }
    public function edit(Room $room)
    {
        return view('rooms.form', ['item' => $room, 'types' => RoomType::all(), 'facilities' => Facility::all(), 'selected' => $room->facilities()->pluck('facilities.id')->all()]);
    }
    public function update(Request $r, Room $room)
    {
        $room->update($this->validated($r, $room));
        $room->facilities()->sync($r->input('facility_ids', []));
        return redirect()->route('rooms.index')->with('success', 'Kamar diperbarui.');
    }
    public function destroy(Room $room)
    {
        $room->delete();
        return back()->with('success', 'Kamar dihapus.');
    }
    private function validated(Request $r, ?Room $room = null)
    {
        return $r->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|max:20|unique:rooms,room_number,' . ($room?->id ?? 'NULL'),
            'floor' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable',
            'facility_ids' => 'array'
        ]);
    }
}
