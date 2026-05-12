@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden pt-12 pb-24 sm:pt-16 lg:pt-32">
    <!-- Hero Content -->
    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-800 mb-8 animate-bounce">
            <span class="flex h-2 w-2 rounded-full bg-primary-500"></span>
            <span class="text-xs font-bold uppercase tracking-wider">New: TaskOrbit v2.0 Is Here</span>
        </div>

        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-8 leading-[1.1]">
            Kelola Tugas Kuliah <br />
            <span class="text-gradient">Jauh Lebih Cerdas.</span>
        </h1>

        <p class="text-lg sm:text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
            Platform manajemen tugas mahasiswa paling modern untuk mengatur deadline, kategori, dan prioritas secara otomatis. Fokus pada hasil, bukan sekadar jadwal.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4 mb-20">
            @guest
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1 flex items-center justify-center">
                    Mulai Sekarang <i class="fa-solid fa-arrow-right ml-3"></i>
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-800 rounded-2xl font-bold text-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Masuk ke Akun
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1">
                    Buka Dashboard <i class="fa-solid fa-chart-pie ml-3"></i>
                </a>
            @endguest
        </div>

        <!-- App Preview Mockup -->
        <div class="relative group mt-10">
            <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-purple-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 p-2 sm:p-4 shadow-2xl">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80" alt="App Preview" class="rounded-2xl w-full object-cover">
                
                <!-- Floating Card UI elements -->
                <div class="absolute -top-6 -right-6 hidden lg:block animate-float">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 flex items-center space-x-4">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-circle-check fa-lg"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-sm font-bold dark:text-white">Proyek PPL</div>
                            <div class="text-xs text-slate-500 uppercase font-bold tracking-tighter">Selesai 100%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-300 dark:hover:border-primary-800 transition-all group">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 text-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bolt-lightning text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 dark:text-white">Prioritas Cerdas</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Algoritma kami menghitung prioritas tugas berdasarkan sisa waktu deadline secara real-time.</p>
            </div>
            
            <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-300 dark:hover:border-primary-800 transition-all group">
                <div class="w-16 h-16 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-line text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 dark:text-white">Statistik Visual</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Pantau perkembangan belajarmu dengan grafik interaktif yang indah di dashboard pribadimu.</p>
            </div>

            <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-300 dark:hover:border-primary-800 transition-all group">
                <div class="w-16 h-16 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wand-magic-sparkles text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 dark:text-white">Dark Mode Native</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Mendukung tema gelap dan terang untuk menjaga matamu tetap nyaman saat bekerja lembur.</p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .animate-float { animation: float 4s ease-in-out infinite; }
</style>
@endsection
