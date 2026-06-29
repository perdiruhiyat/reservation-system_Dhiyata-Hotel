@extends('layouts.user')

@section('title', 'Reservasi Online')

@section('content')
    <div class="mb-4" data-aos="fade-down">
        <div class="section-kicker">Reservasi Online</div>

        <h1 class="h2 fw-bold mb-2">
            Pesan kamar Anda
        </h1>

        <p class="text-secondary mb-0">
            Pilih tanggal menginap dan kamar yang tersedia.
            Data pemesan otomatis diambil dari profil Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('user.bookings.store') }}">
        @csrf

        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="step-card sticky-xl-top" data-aos="fade-right">
                    <div class="step-title">
                        <span class="step-no">1</span>

                        <div>
                            <div class="fw-bold">Informasi Pemesan</div>

                            <div class="small text-secondary">
                                Data diambil dari profil Anda
                            </div>
                        </div>
                    </div>

                    <div class="profile-summary mt-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <div class="fw-bold text-truncate">
                                    {{ auth()->user()->name }}
                                </div>

                                <div class="small text-secondary text-truncate">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>

                        <div class="profile-info-list">
                            <div class="profile-info-item">
                                <div class="profile-info-icon">
                                    <i class="bi bi-person-vcard"></i>
                                </div>

                                <div>
                                    <div class="small text-secondary">
                                        Nomor Identitas
                                    </div>

                                    <div class="fw-semibold">
                                        {{ auth()->user()->identity_number ?: '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="profile-info-item">
                                <div class="profile-info-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>

                                <div>
                                    <div class="small text-secondary">
                                        Nomor Telepon
                                    </div>

                                    <div class="fw-semibold">
                                        {{ auth()->user()->phone ?: '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="profile-info-item">
                                <div class="profile-info-icon">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </div>

                                <div>
                                    <div class="small text-secondary">
                                        Jenis Kelamin
                                    </div>

                                    <div class="fw-semibold">
                                        @if(auth()->user()->gender === 'L')
                                            Laki-laki
                                        @elseif(auth()->user()->gender === 'P')
                                            Perempuan
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="profile-info-item">
                                <div class="profile-info-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>

                                <div>
                                    <div class="small text-secondary">
                                        Alamat
                                    </div>

                                    <div class="fw-semibold">
                                        {{ auth()->user()->address ?: '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary w-100 mt-4">
                            <i class="bi bi-pencil-square me-1"></i>
                            Ubah Profil
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="step-card mb-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="step-title">
                        <span class="step-no">2</span>

                        <div>
                            <div class="fw-bold">Tanggal Menginap</div>

                            <div class="small text-secondary">
                                Pilih waktu check-in dan check-out
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Check-in
                            </label>

                            <input type="date" name="check_in_date" id="checkInDate" value="{{ old('check_in_date') }}"
                                min="{{ now()->format('Y-m-d') }}"
                                class="form-control @error('check_in_date') is-invalid @enderror" required>

                            @error('check_in_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Check-out
                            </label>

                            <input type="date" name="check_out_date" id="checkOutDate" value="{{ old('check_out_date') }}"
                                min="{{ now()->addDay()->format('Y-m-d') }}"
                                class="form-control @error('check_out_date') is-invalid @enderror" required>

                            @error('check_out_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="step-card mb-4" data-aos="fade-left" data-aos-delay="200">
                    <div class="step-title">
                        <span class="step-no">3</span>

                        <div>
                            <div class="fw-bold">Pilih Kamar</div>

                            <div class="small text-secondary">
                                Anda dapat memilih lebih dari satu kamar
                            </div>
                        </div>
                    </div>

                    @error('room_ids')
                        <div class="alert alert-danger mt-3 mb-0">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('room_ids.*')
                        <div class="alert alert-danger mt-3 mb-0">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="row g-3 mt-2">
                        @forelse($rooms as $room)
                                            <div class="col-12 col-md-6" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 2) * 100 }}">
                                                <label class="room-choice h-100">
                                                    <input type="checkbox" name="room_ids[]" value="{{ $room->id }}"
                                                        data-price="{{ $room->roomType->base_price }}" @checked(
                                                            in_array(
                                                                $room->id,
                                                                old('room_ids', [])
                                                            )
                                                        )>

                                                    <span class="room-choice-content">
                                                        <span class="d-flex justify-content-between gap-3">
                                                            <span>
                                                                <span class="small text-secondary d-block">
                                                                    Kamar
                                                                </span>

                                                                <span class="fs-5 fw-bold">
                                                                    {{ $room->room_number }}
                                                                </span>
                                                            </span>

                                                            <span class="check-dot">
                                                                <i class="bi bi-check-lg"></i>
                                                            </span>
                                                        </span>

                                                        <span class="d-block fw-semibold mt-3">
                                                            {{ $room->roomType->name }}
                                                        </span>

                                                        <span class="small text-secondary d-block mt-1">
                                                            <i class="bi bi-people me-1"></i>
                                                            {{ $room->roomType->capacity }} orang
                                                        </span>

                                                        <span class="small text-secondary d-block mt-1">
                                                            <i class="bi bi-building me-1"></i>
                                                            Lantai {{ $room->floor }}
                                                        </span>

                                                        <span class="d-block text-primary fw-bold mt-3">
                                                            Rp
                                                            {{ number_format(
                                $room->roomType->base_price,
                                0,
                                ',',
                                '.'
                            ) }}

                                                            <span class="small text-secondary fw-normal">
                                                                / malam
                                                            </span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Tidak ada kamar yang tersedia.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="step-card" data-aos="fade-left" data-aos-delay="300">
                    <div class="step-title">
                        <span class="step-no">4</span>

                        <div>
                            <div class="fw-bold">Catatan Tambahan</div>

                            <div class="small text-secondary">
                                Opsional
                            </div>
                        </div>
                    </div>

                    <textarea name="notes" class="form-control mt-4 @error('notes') is-invalid @enderror" rows="4"
                        placeholder="Tambahkan kebutuhan khusus bila ada">{{ old('notes') }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="summary-box mt-4">
                        <div>
                            <div class="fw-bold">
                                Ringkasan Reservasi
                            </div>

                            <div class="small text-secondary">
                                <span id="selectedRoomCount">0 kamar</span>
                                ·
                                <span id="nightCount">0 malam</span>
                            </div>

                            <div class="fs-5 fw-bold text-primary mt-1" id="estimatedTotal">
                                Rp 0
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg px-4" @disabled($rooms->isEmpty())>
                            Konfirmasi Reservasi

                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
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
            text-transform: uppercase;
        }

        .step-card {
            padding: 1.5rem;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 1.5rem;
            background: var(--bs-body-bg);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07);
        }

        .sticky-xl-top {
            top: 6.5rem;
        }

        .step-title {
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .step-no {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #d4a017);
            font-weight: 800;
        }

        .profile-summary {
            padding: 1rem;
            border-radius: 1.25rem;
            background: var(--bs-tertiary-bg);
        }

        .profile-avatar {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #d4a017);
            font-size: 1.15rem;
            font-weight: 800;
        }

        .profile-info-list {
            display: grid;
            gap: .75rem;
        }

        .profile-info-item {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: .75rem;
            border-radius: .9rem;
            background: var(--bs-body-bg);
        }

        .profile-info-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 11px;
            color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
        }

        .room-choice {
            position: relative;
            display: block;
            cursor: pointer;
        }

        .room-choice input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .room-choice-content {
            display: block;
            height: 100%;
            padding: 1.15rem;
            border: 2px solid rgba(148, 163, 184, .16);
            border-radius: 1.25rem;
            transition:
                border-color .2s ease,
                background-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .room-choice:hover .room-choice-content {
            transform: translateY(-2px);
            border-color: rgba(13, 148, 136, .35);
        }

        .room-choice input:checked+.room-choice-content {
            border-color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
            box-shadow: 0 10px 25px rgba(13, 148, 136, .12);
        }

        .room-choice input:focus-visible+.room-choice-content {
            outline: 3px solid rgba(13, 148, 136, .22);
            outline-offset: 2px;
        }

        .check-dot {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: transparent;
            background: var(--bs-tertiary-bg);
        }

        .room-choice input:checked+.room-choice-content .check-dot {
            color: #fff;
            background: var(--bs-primary);
        }

        .summary-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.15rem;
            border-radius: 1.25rem;
            background: var(--bs-tertiary-bg);
        }

        @media (max-width: 767.98px) {
            .summary-box {
                flex-direction: column;
                align-items: stretch;
            }

            .summary-box .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkInInput = document.getElementById('checkInDate');
            const checkOutInput = document.getElementById('checkOutDate');
            const roomInputs = document.querySelectorAll(
                'input[name="room_ids[]"]'
            );

            const roomCountElement = document.getElementById(
                'selectedRoomCount'
            );

            const nightCountElement = document.getElementById(
                'nightCount'
            );

            const totalElement = document.getElementById(
                'estimatedTotal'
            );

            function formatCurrency(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(value);
            }

            function calculateNights() {
                if (!checkInInput.value || !checkOutInput.value) {
                    return 0;
                }

                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);

                const difference = checkOut.getTime() - checkIn.getTime();

                return Math.max(
                    0,
                    Math.ceil(difference / (1000 * 60 * 60 * 24))
                );
            }

            function updateCheckOutMinimum() {
                if (!checkInInput.value) {
                    return;
                }

                const date = new Date(checkInInput.value);
                date.setDate(date.getDate() + 1);

                const minimumDate = date.toISOString().split('T')[0];

                checkOutInput.min = minimumDate;

                if (
                    checkOutInput.value &&
                    checkOutInput.value < minimumDate
                ) {
                    checkOutInput.value = '';
                }
            }

            function updateSummary() {
                const selectedRooms = Array.from(roomInputs).filter(
                    input => input.checked
                );

                const nights = calculateNights();

                const roomTotalPerNight = selectedRooms.reduce(
                    (total, input) => {
                        return total + Number(input.dataset.price || 0);
                    },
                    0
                );

                const estimatedTotal = roomTotalPerNight * nights;

                roomCountElement.textContent =
                    `${selectedRooms.length} kamar`;

                nightCountElement.textContent =
                    `${nights} malam`;

                totalElement.textContent =
                    formatCurrency(estimatedTotal);
            }

            checkInInput?.addEventListener('change', function () {
                updateCheckOutMinimum();
                updateSummary();
            });

            checkOutInput?.addEventListener(
                'change',
                updateSummary
            );

            roomInputs.forEach(function (input) {
                input.addEventListener('change', updateSummary);
            });

            updateCheckOutMinimum();
            updateSummary();
        });
    </script>
@endpush