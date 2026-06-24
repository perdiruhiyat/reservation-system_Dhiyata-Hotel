@extends('layouts.app')
@section('title',$item->exists?'Edit Tamu':'Tambah Tamu')
@section('content')
<x-page-header :title="$item->exists?'Edit Data Tamu':'Tambah Data Tamu'"><a href="{{ route('guests.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists?route('guests.update',$item):route('guests.store') }}" class="row g-3">@csrf @if($item->exists)@method('PUT')@endif
            <div class="col-12 col-md-6"><label class="form-label">No. identitas</label><input name="identity_number" value="{{ old('identity_number',$item->identity_number) }}" class="form-control" required></div>
            <div class="col-12 col-md-6"><label class="form-label">Nama lengkap</label><input name="name" value="{{ old('name',$item->name) }}" class="form-control" required></div>
            <div class="col-12 col-md-4"><label class="form-label">Jenis kelamin</label><select name="gender" class="form-select">
                    <option value="L" @selected(old('gender',$item->gender)==='L')>Laki-laki</option>
                    <option value="P" @selected(old('gender',$item->gender)==='P')>Perempuan</option>
                </select></div>
            <div class="col-12 col-md-4"><label class="form-label">Telepon</label><input name="phone" value="{{ old('phone',$item->phone) }}" class="form-control" required></div>
            <div class="col-12 col-md-4"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email',$item->email) }}" class="form-control"></div>
            <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="3">{{ old('address',$item->address) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>@endsection