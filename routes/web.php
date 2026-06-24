<?php

use App\Http\Controllers\{AuthController, BookingController, DashboardController, FacilityController, GuestController, ReportController, RoomController, RoomTypeController, UserBookingController};
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/home', [UserBookingController::class, 'home'])
                ->name('home');

            Route::get('/bookings', [UserBookingController::class, 'index'])
                ->name('bookings.index');

            Route::get('/bookings/create', [UserBookingController::class, 'create'])
                ->name('bookings.create');

            Route::post('/bookings', [UserBookingController::class, 'store'])
                ->name('bookings.store');

            Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])
                ->name('bookings.show');

            Route::post('/bookings/{booking}/pdf', [UserBookingController::class, 'downloadPdf'])
                ->name('bookings.pdf');
        });

    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
        Route::get('/guests/create', [GuestController::class, 'create'])->name('guests.create');
        Route::post('/guests', [GuestController::class, 'store'])->name('guests.store');
        Route::get('/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
        Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::post(
            '/bookings/scan-check-in',
            [BookingController::class, 'scanCheckIn']
        )->name('bookings.scan-check-in');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::patch('/bookings/{booking}/check-in', [BookingController::class, 'checkIn'])->name('bookings.check-in');
        Route::patch('/bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
    });
    Route::middleware('role:admin')->group(function () {
        Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
        Route::resource('room-types', RoomTypeController::class)->except('show');
        Route::resource('facilities', FacilityController::class)->except('show');
        Route::get('/reports/reservations', [ReportController::class, 'index'])
            ->name('reports.reservations');

        Route::get('/reports/reservations/csv', [ReportController::class, 'exportCsv'])
            ->name('reports.reservations.csv');

        Route::get('/reports/reservations/print', [ReportController::class, 'print'])
            ->name('reports.reservations.print');

        Route::get('/reports/reservations/excel', [ReportController::class, 'printExcel'])
            ->name('reports.reservations.excel');
    });
});
