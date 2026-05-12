@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">Dashboard</h2>
        <p class="text-slate-500 dark:text-slate-400">Selamat datang kembali, <span class="font-semibold text-primary-600 dark:text-primary-400">{{ Auth::user()->name }}</span>! Berikut ringkasan produktivitas Anda.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-600/20 transition-all hover:-translate-y-0.5">
            <i class="fa-solid fa-plus mr-2"></i>Tugas Baru
        </a>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i class="fa-solid fa-tags mr-2"></i>Kategori
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Tugas -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 border-l-4 border-l-primary-500 p-6 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-center mb-4">
            <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tugas</h6>
            <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-list-check"></i>
            </div>
        </div>
        <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $taskCount }}</h2>
        <a href="{{ route('tasks.index') }}" class="text-sm font-bold text-primary-600 dark:text-primary-400 hover:underline inline-flex items-center">
            Lihat Semua Tugas <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>

    <!-- Tugas Selesai -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 border-l-4 border-l-emerald-500 p-6 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-center mb-4">
            <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tugas Selesai</h6>
            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
        <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $completedTaskCount }}</h2>
        @php 
            $percentage = $taskCount > 0 ? round(($completedTaskCount / $taskCount) * 100) : 0; 
        @endphp
        <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2 mb-2">
            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
        </div>
        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $percentage }}% dari total tugas diselesaikan</p>
    </div>

    <!-- Total Kategori -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 border-l-4 border-l-amber-500 p-6 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-center mb-4">
            <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</h6>
            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
        <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $categoryCount }}</h2>
        <a href="{{ route('categories.index') }}" class="text-sm font-bold text-amber-600 dark:text-amber-400 hover:underline inline-flex items-center">
            Kelola Kategori <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h6 class="font-bold text-slate-900 dark:text-white flex items-center">
                    <i class="fa-solid fa-chart-bar mr-3 text-primary-500"></i>Statistik Tugas
                </h6>
            </div>
            <div class="p-8 flex items-center justify-center">
                @if($taskCount > 0)
                    <div class="relative w-full h-[300px]">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 dark:text-slate-600">
                            <i class="fa-regular fa-folder-open text-4xl"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 mb-6 font-medium">Belum ada data tugas untuk ditampilkan.</p>
                        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-700 transition-colors">
                            Buat Tugas Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <h6 class="font-bold text-slate-900 dark:text-white flex items-center">
                    <i class="fa-solid fa-clock-rotate-left mr-3 text-sky-500"></i>Status Saat Ini
                </h6>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                <div class="flex justify-between items-center px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center">
                        <span class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 text-amber-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-hourglass-start"></i>
                        </span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">Belum Dikerjakan</span>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-black rounded-full border border-slate-200 dark:border-slate-700">{{ $statusCounts['belum'] }}</span>
                </div>
                <div class="flex justify-between items-center px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center">
                        <span class="w-10 h-10 bg-sky-50 dark:bg-sky-900/20 text-sky-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-spinner"></i>
                        </span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">Sedang Dikerjakan</span>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-black rounded-full border border-slate-200 dark:border-slate-700">{{ $statusCounts['sedang'] }}</span>
                </div>
                <div class="flex justify-between items-center px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center">
                        <span class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">Selesai</span>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-black rounded-full border border-slate-200 dark:border-slate-700">{{ $statusCounts['selesai'] }}</span>
                </div>
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
        
        let chartInstance = new Chart(ctx, {
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
                            color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                            font: {
                                family: "'Inter', sans-serif",
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '75%'
            }
        });

        // Listen for Theme Changes
        window.addEventListener('themeChanged', (e) => {
            const newColor = e.detail.theme === 'dark' ? '#f8fafc' : '#0f172a';
            chartInstance.options.plugins.legend.labels.color = newColor;
            chartInstance.update();
        });
        @endif
    });
</script>
@endpush
