@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Tambah Kategori</h2>
        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 md:p-10">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium" value="{{ old('name') }}" placeholder="Contoh: Kuliah, Pribadi, Organisasi..." required autofocus>
                </div>
                <div>
                    <label for="description" class="block text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium" placeholder="Jelaskan penggunaan kategori ini...">{{ old('description') }}</textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-primary-600 hover:bg-primary-700 text-white font-black rounded-2xl shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-save mr-3"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
