@extends('layouts.app')
@section('title','Data Kamar')

@section('content')
<x-page-header title="Data Kamar" subtitle="Pantau kamar, tipe, lantai, dan statusnya.">
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah
    </a>
    @endif
</x-page-header>

@if(auth()->user()->role === 'petugas')
<div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle-fill me-2"></i>
    Akun petugas hanya dapat melihat data kamar. Perubahan data kamar dilakukan oleh admin.
</div>
@endif

<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3">
            <div class="col-12 col-md-5">
                <input name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Cari nomor kamar...">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tipe</th>
                        <th>Lantai</th>
                        <th>Status</th>
                        @if(auth()->user()->role === 'admin')
                        <th class="text-end">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->room_number }}</td>
                        <td>{{ $item->roomType->name }}</td>
                        <td>{{ $item->floor }}</td>
                        <td>
                            <span class="badge text-bg-{{
                                    $item->status === 'available'
                                        ? 'success'
                                        : ($item->status === 'occupied' ? 'warning' : 'secondary')
                                }}">
                                {{ str_replace('_',' ',$item->status) }}
                            </span>
                        </td>

                        @if(auth()->user()->role === 'admin')
                        <td class="text-end text-nowrap">
                            <a href="{{ route('rooms.edit',$item) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form method="POST"
                                action="{{ route('rooms.destroy',$item) }}"
                                class="d-inline"
                                onsubmit="return confirm('Hapus data kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
                            class="text-center text-secondary py-4">
                            Belum ada data kamar.
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