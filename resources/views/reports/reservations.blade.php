@extends('layouts.app')
@section('title', 'Laporan Reservasi')

@section('content')
    <x-page-header title="Laporan Reservasi" subtitle="Rekap seluruh transaksi reservasi hotel.">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download me-1"></i>
                Export
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                    <a href="{{ route('reports.reservations.csv') }}" class="dropdown-item d-flex align-items-center gap-2">
                        <i class="bi bi-filetype-csv text-success"></i>
                        Export CSV
                    </a>
                </li>

                <li>
                    <a href="{{ route('reports.reservations.excel') }}"
                        class="dropdown-item d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-excel-fill text-success"></i>
                        Export Excel
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a href="{{ route('reports.reservations.print') }}"
                        class="dropdown-item d-flex align-items-center gap-2" target="_blank">
                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                        Print / PDF
                    </a>
                </li>
            </ul>
        </div>

    </x-page-header>

    <div class="card">
        <div class="card-body">
            <form class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>

                <div class="col-6 col-md-3">
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>

                <div class="col-12 col-md-auto">
                    <button class="btn btn-outline-primary w-100">Terapkan</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->booking_code }}</td>
                                <td>{{ $item->guest->name }}</td>
                                <td>{{ $item->rooms->pluck('room_number')->join(', ') }}</td>
                                <td>{{ $item->check_in_date->format('d-m-Y') }}</td>
                                <td>{{ $item->check_out_date->format('d-m-Y') }}</td>
                                <td>{{ str_replace('_', ' ', $item->status) }}</td>
                                <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">
                                    Tidak ada data reservasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $items->links() }}
        </div>
    </div>
@endsection