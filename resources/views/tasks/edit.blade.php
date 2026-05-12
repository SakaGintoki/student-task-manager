@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Edit Tugas</h2>
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 md:p-10">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="title" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Judul Tugas</label>
                    <input type="text" name="title" id="title" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium" value="{{ old('title', $task->title) }}" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Kategori</label>
                        <div class="relative">
                            <select name="category_id" id="category_id" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary-500 transition-all font-medium appearance-none" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="deadline" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Batas Waktu (Deadline)</label>
                        <input type="datetime-local" name="deadline" id="deadline" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary-500 transition-all font-medium" value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}" required>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="5" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium">{{ old('description', $task->description) }}</textarea>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-primary-600 hover:bg-primary-700 text-white font-black rounded-2xl shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-save mr-3"></i> Perbarui Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
