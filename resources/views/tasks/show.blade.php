@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Tugas</h2>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="mb-1">{{ $task->title }}</h3>
                        <span class="badge bg-secondary mb-3">{{ $task->category->name }}</span>
                    </div>
                    <div>
                        <span class="badge @if($task->priority == 'Tinggi' || $task->priority == 'Sangat Tinggi (Overdue)') bg-danger @elseif($task->priority == 'Medium') bg-warning text-dark @else bg-info text-dark @endif">
                            Prioritas: {{ $task->priority }}
                        </span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Status Saat Ini:</h6>
                        @if($task->status == 'Belum Dikerjakan')
                            <span class="badge bg-warning text-dark fs-6">{{ $task->status }}</span>
                        @elseif($task->status == 'Sedang Dikerjakan')
                            <span class="badge bg-info text-dark fs-6">{{ $task->status }}</span>
                        @else
                            <span class="badge bg-success fs-6">{{ $task->status }}</span>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6>Deadline:</h6>
                        <p class="mb-0">{{ $task->deadline->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <h6>Deskripsi:</h6>
                <p class="text-muted">{{ $task->description ?? 'Tidak ada deskripsi.' }}</p>

                <hr>

                <h5>Ubah Status (Proses Bisnis)</h5>
                <div class="d-flex gap-2 mt-3">
                    @if($task->status == 'Belum Dikerjakan')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Sedang Dikerjakan">
                            <button type="submit" class="btn btn-info">Mulai Kerjakan</button>
                        </form>
                    @endif

                    @if($task->status == 'Sedang Dikerjakan')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Selesai">
                            <button type="submit" class="btn btn-success">Tandai Selesai</button>
                        </form>
                    @endif

                    @if($task->status == 'Selesai')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Belum Dikerjakan">
                            <button type="submit" class="btn btn-outline-warning">Batalkan Penyelesaian</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
