@extends('layouts.app')
@section('title','Fasilitas')
@section('content')
<x-page-header title="Fasilitas" subtitle="Kelola fasilitas yang tersedia di kamar."><a href="{{ route('facilities.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form class="row g-2 mb-3">
            <div class="col-12 col-md-5"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari data..."></div>
            <div class="col-auto"><button class="btn btn-outline-primary">Cari</button></div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)<tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description ?: '-' }}</td>
                        <td class="text-end text-nowrap"><a href="{{ route('facilities.edit',$item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('facilities.destroy',$item) }}" class="d-inline" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty<tr>
                        <td colspan="3" class="text-center text-secondary py-4">Belum ada data.</td>
                    </tr>@endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $items->links() }}</div>
    </div>
</div>
@endsection