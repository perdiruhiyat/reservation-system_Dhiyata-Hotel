<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $r)
    {
        $items = Guest::when($r->search, fn($q, $s) => $q->where(fn($x) => $x->where('name', 'like', "%$s%")->orWhere('identity_number', 'like', "%$s%")->orWhere('phone', 'like', "%$s%")))->latest()->paginate(10)->withQueryString();
        return view('guests.index', compact('items'));
    }
    public function create()
    {
        return view('guests.form', ['item' => new Guest]);
    }
    public function store(Request $r)
    {
        Guest::create($this->validated($r));
        return redirect()->route('guests.index')->with('success', 'Data tamu ditambahkan.');
    }
    public function edit(Guest $guest)
    {
        return view('guests.form', ['item' => $guest]);
    }
    public function update(Request $r, Guest $guest)
    {
        $guest->update($this->validated($r, $guest));
        return redirect()->route('guests.index')->with('success', 'Data tamu diperbarui.');
    }
    public function destroy(Guest $guest)
    {
        $guest->delete();
        return back()->with('success', 'Data tamu dihapus.');
    }
    private function validated(Request $r, ?Guest $guest = null)
    {
        return $r->validate([
            'identity_number' => 'required|max:50|unique:guests,identity_number,' . ($guest?->id ?? 'NULL'),
            'name' => 'required|max:120',
            'gender' => 'required|in:L,P',
            'phone' => 'required|max:25',
            'email' => 'nullable|email',
            'address' => 'nullable'
        ]);
    }
}
