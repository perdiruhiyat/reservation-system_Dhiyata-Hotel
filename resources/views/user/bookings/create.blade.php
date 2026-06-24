@extends('layouts.user')
@section('title', 'Reservasi Online')
@section('content')
    <div class="mb-4">
        <div class="section-kicker">Reservasi Online</div>
        <h1 class="h2 fw-bold mb-2">Pesan kamar Anda</h1>
        <p class="text-secondary mb-0">Lengkapi informasi tamu, tanggal menginap, dan kamar pilihan.</p>
    </div>
    <form method="POST" action="{{ route('user.bookings.store') }}">@csrf
        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="step-card sticky-xl-top">
                    <div class="step-title"><span class="step-no">1</span>
                        <div>
                            <div class="fw-bold">Informasi Tamu</div>
                            <div class="small text-secondary">Data pemesan kamar</div>
                        </div>
                    </div>
                    <div class="vstack gap-3 mt-4">
                        <div><label class="form-label fw-semibold">Nama Lengkap</label><input class="form-control"
                                value="{{ auth()->user()->name }}" disabled></div>
                        <div><label class="form-label fw-semibold">Email</label><input class="form-control"
                                value="{{ auth()->user()->email }}" disabled></div>
                        <div><label class="form-label fw-semibold">Nomor Identitas</label><input name="identity_number"
                                value="{{ old('identity_number') }}" class="form-control"
                                placeholder="NIK atau nomor identitas" required></div>
                        <div><label class="form-label fw-semibold">Nomor Telepon</label><input name="phone"
                                value="{{ old('phone') }}" class="form-control" placeholder="081234567890" required></div>
                        <div><label class="form-label fw-semibold">Jenis Kelamin</label><select name="gender"
                                class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select></div>
                        <div><label class="form-label fw-semibold">Alamat</label><textarea name="address"
                                class="form-control" rows="4">{{ old('address') }}</textarea></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-8">
                <div class="step-card mb-4">
                    <div class="step-title"><span class="step-no">2</span>
                        <div>
                            <div class="fw-bold">Tanggal Menginap</div>
                            <div class="small text-secondary">Pilih waktu check-in dan check-out</div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6"><label class="form-label fw-semibold">Check-in</label><input type="date"
                                name="check_in_date" value="{{ old('check_in_date') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Check-out</label><input type="date"
                                name="check_out_date" value="{{ old('check_out_date') }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="step-card mb-4">
                    <div class="step-title"><span class="step-no">3</span>
                        <div>
                            <div class="fw-bold">Pilih Kamar</div>
                            <div class="small text-secondary">Anda dapat memilih lebih dari satu kamar</div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        @forelse($rooms as $room)
                            <div class="col-12 col-md-6">
                                <label class="room-choice h-100">
                                    <input type="checkbox" name="room_ids[]" value="{{ $room->id }}"
                                        @checked(in_array($room->id, old('room_ids', [])))>
                                    <span class="room-choice-content">
                                        <span class="d-flex justify-content-between"><span><span
                                                    class="small text-secondary d-block">Kamar</span><span
                                                    class="fs-5 fw-bold">{{ $room->room_number }}</span></span><span
                                                class="check-dot"><i class="bi bi-check-lg"></i></span></span>
                                        <span class="d-block fw-semibold mt-3">{{ $room->roomType->name }}</span>
                                        <span class="small text-secondary d-block mt-1"><i
                                                class="bi bi-people me-1"></i>{{ $room->roomType->capacity }} orang</span>
                                        <span class="d-block text-primary fw-bold mt-3">Rp
                                            {{ number_format($room->roomType->base_price, 0, ',', '.') }} <span
                                                class="small text-secondary fw-normal">/ malam</span></span>
                                    </span>
                                </label>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">Tidak ada kamar tersedia.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-title"><span class="step-no">4</span>
                        <div>
                            <div class="fw-bold">Catatan Tambahan</div>
                            <div class="small text-secondary">Opsional</div>
                        </div>
                    </div>
                    <textarea name="notes" class="form-control mt-4" rows="4"
                        placeholder="Tambahkan kebutuhan khusus bila ada">{{ old('notes') }}</textarea>
                    <div class="summary-box mt-4">
                        <div>
                            <div class="fw-bold">Siap melanjutkan?</div>
                            <div class="small text-secondary">Pastikan seluruh informasi sudah benar.</div>
                        </div><button class="btn btn-primary btn-lg px-4">Konfirmasi Reservasi <i
                                class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('styles')
    <style>
        .section-kicker {
            color: var(--bs-primary);
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase
        }

        .step-card {
            padding: 1.5rem;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.5rem;
            background: var(--bs-body-bg);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07)
        }

        .sticky-xl-top {
            top: 6.5rem
        }

        .step-title {
            display: flex;
            align-items: center;
            gap: .85rem
        }

        .step-no {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #d4a017);
            font-weight: 800
        }

        .room-choice {
            display: block;
            cursor: pointer
        }

        .room-choice input {
            position: absolute;
            opacity: 0
        }

        .room-choice-content {
            display: block;
            height: 100%;
            padding: 1.15rem;
            border: 2px solid rgba(148, 163, 184, .16);
            border-radius: 1.25rem;
            transition: .2s
        }

        .room-choice input:checked+.room-choice-content {
            border-color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle)
        }

        .check-dot {
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: transparent;
            background: var(--bs-tertiary-bg)
        }

        .room-choice input:checked+.room-choice-content .check-dot {
            color: #fff;
            background: var(--bs-primary)
        }

        .summary-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.15rem;
            border-radius: 1.25rem;
            background: var(--bs-tertiary-bg)
        }

        @media(max-width:767px) {
            .summary-box {
                flex-direction: column;
                align-items: stretch
            }

            .summary-box .btn {
                width: 100%
            }
        }
    </style>
@endpush