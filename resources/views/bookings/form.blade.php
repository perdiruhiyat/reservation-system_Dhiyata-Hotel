@extends('layouts.app') @section('title',$item->exists?'Edit Reservasi':'Buat Reservasi Walk-in') @section('content')
<x-page-header :title="$item->exists?'Edit Reservasi':'Buat Reservasi Walk-in'" subtitle="Pilih tamu lama atau tambahkan tamu baru langsung dari form."><a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Kembali</a></x-page-header>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists?route('bookings.update',$item):route('bookings.store') }}" class="row g-4">@csrf @if($item->exists)@method('PUT')@endif
            @if(!$item->exists)<div class="col-12"><label class="form-label fw-bold">Data Tamu</label>
                <div class="d-flex flex-wrap gap-3 mb-3"><label class="border rounded-4 p-3"><input type="radio" name="guest_mode" value="existing" @checked(old('guest_mode','existing')==='existing' )><span class="ms-2 fw-semibold">Pilih tamu lama</span></label><label class="border rounded-4 p-3"><input type="radio" name="guest_mode" value="new" @checked(old('guest_mode')==='new' )><span class="ms-2 fw-semibold">Tambah tamu baru</span></label></div>
                <div id="existingGuestBox"><label class="form-label">Pilih Tamu</label><select name="guest_id" class="form-select">
                        <option value="">Pilih tamu</option>@foreach($guests as $g)<option value="{{ $g->id }}" @selected(old('guest_id')==$g->id)>{{ $g->name }} — {{ $g->identity_number }}</option>@endforeach
                    </select></div>
                <div id="newGuestBox" class="row g-3 d-none">
                    <div class="col-md-6"><label class="form-label">Nomor Identitas</label><input name="new_identity_number" value="{{ old('new_identity_number') }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input name="new_name" value="{{ old('new_name') }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><select name="new_gender" class="form-select">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select></div>
                    <div class="col-md-4"><label class="form-label">Telepon</label><input name="new_phone" value="{{ old('new_phone') }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="new_email" value="{{ old('new_email') }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Alamat</label><textarea name="new_address" class="form-control">{{ old('new_address') }}</textarea></div>
                </div>
            </div>@else<div class="col-12"><label class="form-label">Tamu</label><select name="guest_id" class="form-select">@foreach($guests as $g)<option value="{{ $g->id }}" @selected(old('guest_id',$item->guest_id)==$g->id)>{{ $g->name }}</option>@endforeach</select></div>@endif
            <div class="col-6 col-lg-3"><label class="form-label">Check-in</label><input type="date" name="check_in_date" value="{{ old('check_in_date',optional($item->check_in_date)->format('Y-m-d')) }}" class="form-control" required></div>
            <div class="col-6 col-lg-3"><label class="form-label">Check-out</label><input type="date" name="check_out_date" value="{{ old('check_out_date',optional($item->check_out_date)->format('Y-m-d')) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label fw-bold">Pilih Kamar</label>
                <div class="row g-3">@foreach($rooms as $room)<div class="col-12 col-sm-6 col-xl-4"><label class="border rounded-4 p-3 w-100"><input type="checkbox" name="room_ids[]" value="{{ $room->id }}" @checked(in_array($room->id,old('room_ids',$selectedRooms)))><strong class="ms-2">Kamar {{ $room->room_number }}</strong>
                            <div class="small text-secondary ms-4">{{ $room->roomType->name }} · Rp {{ number_format($room->roomType->base_price,0,',','.') }}/malam</div>
                        </label></div>@endforeach</div>
            </div>
            <div class="col-12"><label class="form-label">Catatan</label><textarea name="notes" class="form-control">{{ old('notes',$item->notes) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Simpan Reservasi</button></div>
        </form>
    </div>
</div>
@endsection @if(!$item->exists) @push('scripts')<script>
    function updateGuestMode() {
        const m = document.querySelector('input[name="guest_mode"]:checked')?.value || 'existing';
        document.getElementById('existingGuestBox').classList.toggle('d-none', m !== 'existing');
        document.getElementById('newGuestBox').classList.toggle('d-none', m !== 'new');
    }
    document.querySelectorAll('input[name="guest_mode"]').forEach(x => x.addEventListener('change', updateGuestMode));
    updateGuestMode();
</script>@endpush @endif