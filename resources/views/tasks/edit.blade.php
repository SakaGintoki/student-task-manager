@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Tugas</h2>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Tugas</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Perbarui Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
