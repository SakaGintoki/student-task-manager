@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center min-vh-50 py-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Buat Akun TaskOrbit</h3>
                    <p class="text-muted">Mulai kelola tugas akademik Anda dengan lebih baik</p>
                </div>
                
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control border-start-0 bg-light" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 bg-light" value="{{ old('email') }}" placeholder="nama@email.com" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-medium text-muted small text-uppercase tracking-wide">Konfirmasi Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-check-double text-muted"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg py-2 fw-bold">Daftar Sekarang</button>
                    </div>
                </form>
                
                <div class="text-center">
                    <p class="text-muted small mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
