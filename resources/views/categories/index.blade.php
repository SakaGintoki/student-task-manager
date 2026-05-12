@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-0">Kategori Tugas</h2>
        <p class="text-muted mb-0">Kelompokkan tugas Anda agar lebih terorganisir.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus me-2"></i>Tambah Kategori
    </a>
</div>

<div class="row g-4">
    @forelse($categories as $category)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-elevate">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-folder-open fa-lg"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Menghapus kategori akan menghapus semua tugas di dalamnya. Yakin ingin melanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash me-2"></i>Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                    <p class="card-text text-muted small mb-4">{{ $category->description ?: 'Tidak ada deskripsi untuk kategori ini.' }}</p>
                </div>
                <div class="card-footer bg-light border-top-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-medium">Jumlah Tugas</span>
                        <span class="badge bg-primary rounded-pill px-3">{{ $category->tasks_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fa-solid fa-folder-tree text-muted opacity-25" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-muted">Belum ada kategori</h5>
                    <p class="text-muted mb-4">Mulai kelompokkan tugas Anda dengan membuat kategori pertama.</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Kategori</a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
