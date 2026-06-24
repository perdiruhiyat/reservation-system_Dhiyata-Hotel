@extends('layouts.app')
@section('title',$item->exists?'Edit Kamar':'Tambah Kamar')
@section('content')
<x-page-header :title="$item->exists?'Edit Kamar':'Tambah Kamar'"><a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists?route('rooms.update',$item):route('rooms.store') }}" class="row g-3">@csrf @if($item->exists)@method('PUT')@endif
            <div class="col-12 col-md-4"><label class="form-label">Nomor kamar</label><input name="room_number" value="{{ old('room_number',$item->room_number) }}" class="form-control" required></div>
            <div class="col-12 col-md-4"><label class="form-label">Tipe kamar</label><select name="room_type_id" class="form-select" required>@foreach($types as $type)<option value="{{ $type->id }}" @selected(old('room_type_id',$item->room_type_id)==$type->id)>{{ $type->name }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2"><label class="form-label">Lantai</label><input type="number" name="floor" value="{{ old('floor',$item->floor) }}" class="form-control" min="1" required></div>
            <div class="col-12 col-md-2"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['available'=>'Tersedia','occupied'=>'Terisi','maintenance'=>'Perawatan'] as $v=>$l)<option value="{{ $v }}" @selected(old('status',$item->status)===$v)>{{ $l }}</option>@endforeach</select></div>
            <div class="col-12"><label class="form-label">Fasilitas</label>
                <div class="row g-2">@foreach($facilities as $f)<div class="col-6 col-md-4 col-xl-3"><label class="border rounded p-2 w-100"><input type="checkbox" name="facility_ids[]" value="{{ $f->id }}" @checked(in_array($f->id,old('facility_ids',$selected)))> {{ $f->name }}</label></div>@endforeach</div>
            </div>
            <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description',$item->description) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>@endsection