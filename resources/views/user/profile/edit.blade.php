@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="mb-4" data-aos="fade-down">
                <div class="section-kicker">Akun Saya</div>
                <h1 class="h2 fw-bold mb-1">Profil Saya</h1>
                <p class="text-secondary mb-0">
                    Data ini akan digunakan otomatis ketika membuat reservasi.
                </p>
            </div>

            <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('user.profile.update') }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>

                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror" required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>

                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror" required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Identitas</label>

                            <input type="text" name="identity_number"
                                value="{{ old('identity_number', $user->identity_number) }}"
                                class="form-control @error('identity_number') is-invalid @enderror"
                                placeholder="NIK/KTP/Paspor" required>

                            @error('identity_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>

                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="form-control @error('phone') is-invalid @enderror" required>

                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>

                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Pilih jenis kelamin</option>

                                <option value="L" @selected(old('gender', $user->gender) === 'L')>
                                    Laki-laki
                                </option>

                                <option value="P" @selected(old('gender', $user->gender) === 'P')>
                                    Perempuan
                                </option>
                            </select>

                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>

                            <textarea name="address" rows="4" class="form-control @error('address') is-invalid @enderror"
                                required>{{ old('address', $user->address) }}</textarea>

                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .section-kicker {
            color: var(--bs-primary);
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
    </style>
@endpush