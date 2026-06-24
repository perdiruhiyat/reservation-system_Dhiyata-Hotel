<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $r)
    {
        $items = Facility::when($r->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))->latest()->paginate(10)->withQueryString();
        return view('facilities.index', compact('items'));
    }
    public function create()
    {
        return view('facilities.form', ['item' => new Facility]);
    }
    public function store(Request $r)
    {
        Facility::create($r->validate(['name' => 'required|max:100', 'description' => 'nullable']));
        return redirect()->route('facilities.index')->with('success', 'Fasilitas ditambahkan.');
    }
    public function edit(Facility $facility)
    {
        return view('facilities.form', ['item' => $facility]);
    }
    public function update(Request $r, Facility $facility)
    {
        $facility->update($r->validate(['name' => 'required|max:100', 'description' => 'nullable']));
        return redirect()->route('facilities.index')->with('success', 'Fasilitas diperbarui.');
    }
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return back()->with('success', 'Fasilitas dihapus.');
    }
}
