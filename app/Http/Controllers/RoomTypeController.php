<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class RoomTypeController extends Controller
{
    public function index(Request $r)
    {
        $items = RoomType::when($r->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))->latest()->paginate(10)->withQueryString();
        return view('room-types.index', compact('items'));
    }

    public function create()
    {
        return view('room-types.form', ['item' => new RoomType]);
    }

    public function store(Request $r)
    {
        $data = $this->validated($r);

        if ($r->hasFile('image')) {
            // Menyimpan ke folder 'public/room-types'
            $data['image'] = $r->file('image')->store('room-types', 'public');
        }

        RoomType::create($data);
        return redirect()->route('room-types.index')->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function edit(RoomType $roomType)
    {
        return view('room-types.form', ['item' => $roomType]);
    }

    public function update(Request $r, RoomType $roomType)
    {
        $data = $this->validated($r);
        if ($r->hasFile('image')) {
            // Hapus gambar lama jika sebelumnya sudah ada gambar terikat
            if ($roomType->image) {
                Storage::disk('public')->delete($roomType->image);
            }
            // Simpan gambar baru
            $data['image'] = $r->file('image')->store('room-types', 'public');
        }

        $roomType->update($data);
        return redirect()->route('room-types.index')->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        if ($roomType->image) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();
        return back()->with('success', 'Tipe kamar berhasil dihapus.');
    }

    private function validated(Request $r)
    {
        return $r->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'base_price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
    }
}
