@extends('layouts.app')
@section('title','Data Tamu')

@section('content')
<x-page-header title="Data Tamu" subtitle="Kelola identitas dan kontak tamu hotel.">
    <a href="{{ route('guests.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah
    </a>
</x-page-header>

<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3">
            <div class="col-12 col-md-5">
                <input name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Cari nama, identitas, atau telepon...">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>No. Identitas</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->identity_number }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->email ?: '-' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('guests.edit',$item) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            @if(auth()->user()->role === 'admin')
                            <form method="POST"
                                action="{{ route('guests.destroy',$item) }}"
                                class="d-inline"
                                onsubmit="return confirm('Hapus data tamu ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Belum ada data tamu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $items->links() }}</div>
    </div>
</div>
@endsection