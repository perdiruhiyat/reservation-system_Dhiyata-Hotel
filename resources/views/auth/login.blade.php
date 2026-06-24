@extends('layouts.auth')
@section('title','Login')
@section('content')
<div class="mb-4">
    <div class="text-primary fw-bold small text-uppercase mb-2">Selamat Datang</div>
    <h2 class="fw-bold mb-2">Masuk ke Dhiyata Hotel</h2>
    <p class="text-secondary mb-0">Masuk untuk melakukan reservasi atau mengelola layanan hotel.</p>
</div>
@if($errors->any())<div class="alert alert-danger border-0">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login') }}" class="vstack gap-3">@csrf
    <div><label class="form-label fw-semibold">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus></div>
    <div><label class="form-label fw-semibold">Password</label><input type="password" name="password" class="form-control" required></div>
    <div class="form-check"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label for="remember" class="form-check-label">Ingat saya</label></div>
    <button class="btn btn-primary">Masuk <i class="bi bi-arrow-right ms-1"></i></button>
    <p class="text-center text-secondary mb-0">Belum memiliki akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar sebagai tamu</a></p>
</form>
@endsection