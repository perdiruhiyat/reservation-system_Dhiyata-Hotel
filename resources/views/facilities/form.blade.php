@extends('layouts.app')
@section('title',$item->exists?'Edit Fasilitas':'Tambah Fasilitas')
@section('content')
<x-page-header :title="$item->exists?'Edit Fasilitas':'Tambah Fasilitas'"><a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists?route('facilities.update',$item):route('facilities.store') }}" class="row g-3">@csrf @if($item->exists)@method('PUT')@endif
            <div class="col-12"><label class="form-label">Nama fasilitas</label><input name="name" value="{{ old('name',$item->name) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="4">{{ old('description',$item->description) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>@endsection