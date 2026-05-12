@extends('layouts.app')

@section('content')
<div class="row align-items-center min-vh-75 py-5">
    <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
        <h1 class="display-3 fw-bold mb-3">Tingkatkan Produktivitas Akademik Anda dengan <span class="text-gradient">TaskOrbit</span></h1>
        <p class="lead text-muted mb-4 pe-lg-5">Platform manajemen tugas mahasiswa yang modern, responsif, dan intuitif. Jangan biarkan deadline terlewat, kelola semuanya di satu tempat.</p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start mt-4">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 fw-semibold"><i class="fa-solid fa-rocket me-2"></i>Mulai Sekarang, Gratis</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4 py-3 fw-semibold text-dark border-2"><i class="fa-solid fa-right-to-bracket me-2"></i>Masuk</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3 fw-semibold"><i class="fa-solid fa-chart-pie me-2"></i>Buka Dashboard Saya</a>
            @endguest
        </div>
        <div class="mt-5 d-flex align-items-center justify-content-center justify-content-lg-start text-muted">
            <div class="d-flex me-3">
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
            </div>
            <span class="small fw-medium">Dipercaya oleh ribuan mahasiswa</span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="position-relative">
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 start-0 translate-middle text-primary opacity-25" style="z-index:-1; font-size:4rem;"><i class="fa-solid fa-certificate"></i></div>
            <div class="position-absolute bottom-0 end-0 translate-middle-y text-info opacity-25" style="z-index:-1; font-size:5rem;"><i class="fa-solid fa-circle"></i></div>
            
            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Student Workspace" class="img-fluid rounded-4 shadow-lg w-100" style="object-fit: cover; height: 500px;">
            
            <!-- Floating Card -->
            <div class="position-absolute bottom-0 start-0 translate-middle-x mb-5 bg-white p-3 rounded-4 shadow-lg border d-none d-md-block" style="width:250px;">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                        <i class="fa-solid fa-check-double fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Tugas Selesai</h6>
                        <small class="text-muted">Desain PPL - 100%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
