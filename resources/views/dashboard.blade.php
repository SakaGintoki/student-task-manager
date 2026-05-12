@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>! Berikut ringkasan produktivitas Anda.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary shadow-sm"><i class="fa-solid fa-plus me-2"></i>Tugas Baru</a>
        <a href="{{ route('categories.create') }}" class="btn btn-outline-primary bg-white"><i class="fa-solid fa-tags me-2"></i>Kategori</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Tugas -->
    <div class="col-md-4">
        <div class="card hover-elevate h-100 border-0 shadow-sm" style="border-left: 5px solid var(--primary-color) !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title text-muted mb-0 fw-semibold text-uppercase tracking-wide">Total Tugas</h6>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                </div>
                <h2 class="display-5 fw-bold text-dark mb-0">{{ $taskCount }}</h2>
                <div class="mt-3">
                    <a href="{{ route('tasks.index') }}" class="text-decoration-none text-primary fw-medium small">Lihat Semua Tugas <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas Selesai -->
    <div class="col-md-4">
        <div class="card hover-elevate h-100 border-0 shadow-sm" style="border-left: 5px solid #10b981 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title text-muted mb-0 fw-semibold text-uppercase tracking-wide">Tugas Selesai</h6>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                </div>
                <h2 class="display-5 fw-bold text-dark mb-0">{{ $completedTaskCount }}</h2>
                <div class="mt-3">
                    @php 
                        $percentage = $taskCount > 0 ? round(($completedTaskCount / $taskCount) * 100) : 0; 
                    @endphp
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">{{ $percentage }}% dari total tugas diselesaikan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-md-4">
        <div class="card hover-elevate h-100 border-0 shadow-sm" style="border-left: 5px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title text-muted mb-0 fw-semibold text-uppercase tracking-wide">Kategori</h6>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
                <h2 class="display-5 fw-bold text-dark mb-0">{{ $categoryCount }}</h2>
                <div class="mt-3">
                    <a href="{{ route('categories.index') }}" class="text-decoration-none text-warning fw-medium small" style="color: #d97706 !important;">Kelola Kategori <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-bar me-2 text-primary"></i>Statistik Tugas</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if($taskCount > 0)
                    <div style="height: 250px; width: 100%;">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fa-regular fa-folder-open mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                        <p>Belum ada data tugas untuk ditampilkan.</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">Buat Tugas Pertama</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2 text-info"></i>Status Saat Ini</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush border-0">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning p-2 rounded-circle me-3"><i class="fa-solid fa-hourglass-start text-dark"></i></span>
                            <span class="fw-medium">Belum Dikerjakan</span>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3">{{ $statusCounts['belum'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-info p-2 rounded-circle me-3"><i class="fa-solid fa-spinner text-white"></i></span>
                            <span class="fw-medium">Sedang Dikerjakan</span>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3">{{ $statusCounts['sedang'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success p-2 rounded-circle me-3"><i class="fa-solid fa-check"></i></span>
                            <span class="fw-medium">Selesai</span>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3">{{ $statusCounts['selesai'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($taskCount > 0)
        const ctx = document.getElementById('taskStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'],
                datasets: [{
                    data: [{{ $statusCounts['belum'] }}, {{ $statusCounts['sedang'] }}, {{ $statusCounts['selesai'] }}],
                    backgroundColor: [
                        '#fbbf24', // warning
                        '#0ea5e9', // info
                        '#10b981'  // success
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                family: "'Poppins', sans-serif"
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '65%'
            }
        });
        @endif
    });
</script>
@endpush
