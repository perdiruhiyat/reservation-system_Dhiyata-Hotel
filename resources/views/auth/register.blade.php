@extends('layouts.auth')
@section('title','Register')

@section('content')
<div class="mb-4">
    <div class="text-primary fw-bold small text-uppercase mb-2">Create Account</div>
    <h2 class="fw-bold mb-2">Daftar akun petugas</h2>
    <p class="text-secondary mb-0">Lengkapi data berikut untuk membuat akun baru.</p>
</div>

@if($errors->any())
<div class="alert alert-danger border-0">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}" class="vstack gap-3">
    @csrf

    <div>
        <label class="form-label fw-semibold">Nama</label>
        <input name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div>
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div>
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div>
        <label class="form-label fw-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-primary">
        Buat Akun <i class="bi bi-arrow-right ms-1"></i>
    </button>

    <p class="text-center text-secondary mb-0">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Masuk</a>
    </p>
</form>
@endsection