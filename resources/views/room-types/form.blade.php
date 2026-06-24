@extends('layouts.app')
@section('title',$item->exists?'Edit Tipe Kamar':'Tambah Tipe Kamar')
@section('content')
<x-page-header :title="$item->exists?'Edit Tipe Kamar':'Tambah Tipe Kamar'"><a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists?route('room-types.update',$item):route('room-types.store') }}" class="row g-3">@csrf @if($item->exists)@method('PUT')@endif
            <div class="col-12 col-md-6"><label class="form-label">Nama tipe</label><input name="name" value="{{ old('name',$item->name) }}" class="form-control" required></div>
            <div class="col-12 col-md-3"><label class="form-label">Kapasitas</label><input type="number" name="capacity" value="{{ old('capacity',$item->capacity) }}" class="form-control" min="1" required></div>
            <div class="col-12 col-md-3"><label class="form-label">Harga dasar</label><input type="number" name="base_price" value="{{ old('base_price',$item->base_price) }}" class="form-control" min="0" required></div>
            <div class="col-12">
                <label class="form-label">Gambar Tipe Kamar</label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp">

                <div class="form-text">
                    Maksimal 2 MB. Format JPG, PNG, atau WebP.
                </div>
            </div>
            <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4">{{ old('description',$item->description) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>@endsection