@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Detail Tugas</h2>
        <div class="flex gap-3">
            <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-amber-500/20 transition-all">
                <i class="fa-solid fa-pen-to-square mr-2"></i>Edit
            </a>
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-sm font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row justify-between items-start mb-10 gap-6">
                <div>
                    <span class="inline-block px-4 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-black rounded-full border border-slate-200 dark:border-slate-700 uppercase tracking-widest mb-4">
                        {{ $task->category->name }}
                    </span>
                    <h3 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white leading-tight">{{ $task->title }}</h3>
                </div>
                <div class="shrink-0">
                    <span class="inline-block px-5 py-2.5 rounded-2xl text-sm font-black uppercase tracking-wider
                        @if($task->priority == 'Tinggi' || $task->priority == 'Sangat Tinggi (Overdue)') bg-red-500 text-white shadow-lg shadow-red-500/20 
                        @elseif($task->priority == 'Medium') bg-amber-500 text-white shadow-lg shadow-amber-500/20 
                        @else bg-sky-500 text-white shadow-lg shadow-sky-500/20 
                        @endif">
                        <i class="fa-solid fa-signal mr-2 text-xs"></i> Prioritas: {{ $task->priority }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <div class="bg-primary-50 dark:bg-primary-900/10 rounded-3xl p-6 border border-primary-100 dark:border-primary-800/50">
                    <h6 class="text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-3">Status Saat Ini</h6>
                    @if($task->status == 'Belum Dikerjakan')
                        <div class="inline-flex items-center text-amber-600 dark:text-amber-400 font-black text-lg">
                            <i class="fa-solid fa-hourglass-start mr-3"></i>{{ $task->status }}
                        </div>
                    @elseif($task->status == 'Sedang Dikerjakan')
                        <div class="inline-flex items-center text-sky-600 dark:text-sky-400 font-black text-lg">
                            <i class="fa-solid fa-spinner fa-spin-pulse mr-3"></i>{{ $task->status }}
                        </div>
                    @else
                        <div class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-black text-lg">
                            <i class="fa-solid fa-check-double mr-3"></i>{{ $task->status }}
                        </div>
                    @endif
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-6 border border-slate-100 dark:border-slate-800">
                    <h6 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Batas Waktu (Deadline)</h6>
                    <div class="inline-flex items-center text-lg font-black {{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status != 'Selesai' ? 'text-red-600' : 'text-slate-900 dark:text-white' }}">
                        <i class="fa-regular fa-calendar-xmark mr-3"></i>{{ $task->deadline->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>
            </div>

            <div class="mb-12">
                <h6 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest mb-4 flex items-center">
                    <i class="fa-solid fa-align-left mr-3 text-primary-500"></i>Deskripsi Tugas
                </h6>
                <div class="bg-slate-50 dark:bg-slate-800/30 rounded-3xl p-6 md:p-8 border border-slate-100 dark:border-slate-800">
                    @if($task->description)
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">{{ $task->description }}</p>
                    @else
                        <p class="text-slate-400 dark:text-slate-500 italic">Tidak ada deskripsi yang ditambahkan untuk tugas ini.</p>
                    @endif
                </div>
            </div>

            <div class="pt-10 border-t border-slate-100 dark:border-slate-800 text-center">
                <h5 class="text-lg font-black text-slate-900 dark:text-white mb-6">Ubah Status Tugas</h5>
                <div class="flex flex-wrap justify-center gap-4">
                    @if($task->status == 'Belum Dikerjakan')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Sedang Dikerjakan">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-sky-500 hover:bg-sky-600 text-white font-black rounded-2xl shadow-xl shadow-sky-500/20 transition-all hover:-translate-y-1">
                                <i class="fa-solid fa-play mr-3"></i> Mulai Kerjakan
                            </button>
                        </form>
                    @endif

                    @if($task->status == 'Sedang Dikerjakan')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Selesai">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-500/20 transition-all hover:-translate-y-1">
                                <i class="fa-solid fa-check-double mr-3"></i> Tandai Selesai
                            </button>
                        </form>
                    @endif

                    @if($task->status == 'Selesai')
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Belum Dikerjakan">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-white dark:bg-slate-900 border-2 border-amber-500 text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/10 font-black rounded-2xl transition-all hover:-translate-y-1">
                                <i class="fa-solid fa-rotate-left mr-3"></i> Batalkan Penyelesaian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
