@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="max-w-4xl mx-auto text-center mb-12">
    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">Daftar Tugas</h2>
    <p class="text-slate-500 dark:text-slate-400 text-lg mb-8">Kelola, pantau, dan selesaikan seluruh tugas akademik Anda dengan TaskOrbit.</p>
    <div class="flex justify-center">
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Tugas Baru
        </a>
    </div>
</div>

<!-- Filter & Search Bar -->
<div class="max-w-5xl mx-auto mb-12">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-4 md:p-6">
        <form action="{{ route('tasks.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-5 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all" placeholder="Cari judul tugas..." value="{{ request('search') }}">
            </div>
            <div class="md:col-span-4 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-filter"></i>
                </span>
                <select name="status" class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-primary-500 transition-all appearance-none">
                    <option value="">Semua Status</option>
                    <option value="Belum Dikerjakan" {{ request('status') == 'Belum Dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                    <option value="Sedang Dikerjakan" {{ request('status') == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-grow py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-600/20 transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('tasks.index') }}" class="p-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="Reset Filter">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Task Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($tasks as $task)
        <div class="group bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
            <div class="p-8 pb-4 flex justify-between items-start">
                <span class="px-4 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-black rounded-full border border-primary-100 dark:border-primary-800/50 uppercase tracking-wider">
                    {{ $task->category->name }}
                </span>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1">
                        <i class="fa-solid fa-ellipsis-vertical text-xl"></i>
                    </button>
                    <!-- Simple Dropdown (Using standard JS if Alpine not present, but let's use a simple one) -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 py-2 z-20">
                        <a href="{{ route('tasks.show', $task) }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fa-solid fa-eye mr-3 text-sky-500"></i> Detail Tugas
                        </a>
                        <a href="{{ route('tasks.edit', $task) }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fa-solid fa-pen-to-square mr-3 text-amber-500"></i> Ubah Tugas
                        </a>
                        <hr class="my-1 border-slate-100 dark:border-slate-700">
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="fa-solid fa-trash mr-3"></i> Hapus Tugas
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="px-8 flex-grow">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white leading-tight mb-4 group-hover:text-primary-600 transition-colors">
                    <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                </h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm font-medium text-slate-500 dark:text-slate-400">
                        <div class="w-8 h-8 bg-slate-50 dark:bg-slate-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <span class="{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status != 'Selesai' ? 'text-red-600 font-black' : '' }}">
                            {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y, H:i') }}
                        </span>
                    </div>
                    <div class="flex items-center text-sm font-medium text-slate-500 dark:text-slate-400">
                        <div class="w-8 h-8 bg-slate-50 dark:bg-slate-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fa-solid fa-signal text-xs"></i>
                        </div>
                        <span>Prioritas: 
                            <span class="font-bold
                                @if($task->priority == 'Tinggi' || $task->priority == 'Sangat Tinggi (Overdue)') text-red-600 
                                @elseif($task->priority == 'Medium') text-amber-600 
                                @else text-sky-600 
                                @endif">
                                {{ $task->priority }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8">
                @if($task->status == 'Belum Dikerjakan')
                    <div class="w-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 py-3 rounded-2xl text-center text-xs font-black uppercase tracking-widest border border-amber-100 dark:border-amber-800/50">
                        <i class="fa-solid fa-hourglass-start mr-2"></i> {{ $task->status }}
                    </div>
                @elseif($task->status == 'Sedang Dikerjakan')
                    <div class="w-full bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400 py-3 rounded-2xl text-center text-xs font-black uppercase tracking-widest border border-sky-100 dark:border-sky-800/50">
                        <i class="fa-solid fa-spinner fa-spin-pulse mr-2"></i> {{ $task->status }}
                    </div>
                @else
                    <div class="w-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 py-3 rounded-2xl text-center text-xs font-black uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/50">
                        <i class="fa-solid fa-check-double mr-2"></i> {{ $task->status }}
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-200 dark:border-slate-800 p-12 text-center">
                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-600">
                    <i class="fa-solid fa-clipboard-list text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Tidak ada tugas ditemukan</h4>
                <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm mx-auto">
                    @if(request()->hasAny(['search', 'status']))
                        Kami tidak menemukan tugas yang cocok dengan kriteria pencarian Anda. Silakan coba kata kunci lain.
                    @else
                        Anda belum memiliki daftar tugas akademik. Mari kita mulai produktivitas Anda dengan membuat tugas pertama!
                    @endif
                </p>
                <div class="flex justify-center gap-4">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('tasks.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-2xl hover:bg-slate-200 transition-colors">Tampilkan Semua</a>
                    @else
                        <a href="{{ route('tasks.create') }}" class="px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-lg shadow-primary-600/20 hover:bg-primary-700 transition-colors"><i class="fa-solid fa-plus mr-2"></i>Tambah Tugas</a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

@if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $tasks->links() }}
    </div>
@endif

@push('scripts')
<script>
    // Simple script to handle dropdowns if Alpine isn't used
    document.addEventListener('click', function(event) {
        const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
        // This is a placeholder, I used x-data in the template assuming Alpine might be available or I'll add a simple script
    });
</script>
@endpush
@endsection
