@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="max-w-4xl mx-auto text-center mb-12">
    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">Kategori Tugas</h2>
    <p class="text-slate-500 dark:text-slate-400 text-lg mb-8">Kelompokkan tugas akademik Anda berdasarkan kategori untuk pengorganisasian yang lebih baik.</p>
    <div class="flex justify-center">
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>
</div>

<!-- Category Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($categories as $category)
        <div class="group bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
            <div class="p-8 pb-4 flex justify-between items-start">
                <div class="w-14 h-14 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1">
                        <i class="fa-solid fa-ellipsis-vertical text-xl"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 py-2 z-20">
                        <a href="{{ route('categories.edit', $category) }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fa-solid fa-pen-to-square mr-3 text-amber-500"></i> Ubah Kategori
                        </a>
                        <hr class="my-1 border-slate-100 dark:border-slate-700">
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Menghapus kategori akan menghapus semua tugas di dalamnya. Yakin ingin melanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="fa-solid fa-trash mr-3"></i> Hapus Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="px-8 flex-grow">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white leading-tight mb-3 group-hover:text-primary-600 transition-colors">
                    {{ $category->name }}
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed line-clamp-2">
                    {{ $category->description ?: 'Tidak ada deskripsi detail untuk kategori ini.' }}
                </p>
            </div>

            <div class="p-8 pt-4">
                <div class="flex justify-between items-center px-5 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Tugas</span>
                    <span class="px-3 py-1 bg-primary-600 text-white text-xs font-black rounded-full shadow-sm">{{ $category->tasks_count }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-200 dark:border-slate-800 p-12 text-center">
                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-600">
                    <i class="fa-solid fa-folder-tree text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Belum ada kategori</h4>
                <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm mx-auto">
                    Kelompokkan tugas kuliah Anda dengan membuat kategori seperti 'Kuliah', 'Project', atau 'Praktikum' untuk memulai.
                </p>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-600/20 hover:bg-primary-700 transition-colors">
                    <i class="fa-solid fa-plus mr-2"></i>Buat Kategori Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
