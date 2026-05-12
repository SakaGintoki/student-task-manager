@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">Daftar Tugas</h2>
        <p class="text-muted mb-0">Kelola dan pantau semua tugas akademik Anda.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus me-2"></i>Tambah Tugas Baru
    </a>
</div>

<!-- Filter & Search Bar -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('tasks.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari judul tugas..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Belum Dikerjakan" {{ request('status') == 'Belum Dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                    <option value="Sedang Dikerjakan" {{ request('status') == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="fa-solid fa-rotate-right"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Task Grid -->
<div class="row g-4">
    @forelse($tasks as $task)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-elevate">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-start">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">{{ $task->category->name }}</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item" href="{{ route('tasks.show', $task) }}"><i class="fa-solid fa-eye me-2 text-info"></i>Detail</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.edit', $task) }}"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold text-truncate mb-3" title="{{ $task->title }}">
                        <a href="{{ route('tasks.show', $task) }}" class="text-dark text-decoration-none stretched-link">{{ $task->title }}</a>
                    </h5>
                    
                    <div class="d-flex flex-column gap-2 mb-3">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fa-regular fa-calendar me-2 w-15px text-center"></i>
                            <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status != 'Selesai' ? 'text-danger fw-bold' : '' }}">
                                {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fa-solid fa-layer-group me-2 w-15px text-center"></i>
                            <span>Prioritas: 
                                <strong class="
                                    @if($task->priority == 'Tinggi' || $task->priority == 'Sangat Tinggi (Overdue)') text-danger 
                                    @elseif($task->priority == 'Medium') text-warning 
                                    @else text-info 
                                    @endif">
                                    {{ $task->priority }}
                                </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 pb-4 pt-0">
                    @if($task->status == 'Belum Dikerjakan')
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning w-100 py-2"><i class="fa-solid fa-hourglass-start me-1"></i> {{ $task->status }}</span>
                    @elseif($task->status == 'Sedang Dikerjakan')
                        <span class="badge bg-info bg-opacity-10 text-info border border-info w-100 py-2"><i class="fa-solid fa-spinner fa-spin-pulse me-1"></i> {{ $task->status }}</span>
                    @else
                        <span class="badge bg-success bg-opacity-10 text-success border border-success w-100 py-2"><i class="fa-solid fa-check-double me-1"></i> {{ $task->status }}</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fa-solid fa-clipboard-list text-muted opacity-25" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-muted">Tidak ada tugas ditemukan</h5>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'status']))
                            Coba sesuaikan filter atau kata kunci pencarian Anda.
                        @else
                            Anda belum menambahkan tugas apapun. Mulai kelola tugas Anda sekarang!
                        @endif
                    </p>
                    @if(!request()->hasAny(['search', 'status']))
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Tugas</a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

@if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
