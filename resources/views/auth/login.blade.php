@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center min-vh-50 py-5">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-right-to-bracket fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Selamat Datang Kembali</h3>
                    <p class="text-muted">Masuk untuk mengelola tugas-tugas Anda</p>
                </div>
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 bg-light" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Kata Sandi</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg py-2 fw-bold">Masuk Sekarang</button>
                    </div>
                </form>
                
                <div class="text-center">
                    <p class="text-muted small mb-0">Belum memiliki akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
