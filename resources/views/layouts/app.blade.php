<!DOCTYPE html>
<html lang="id" class="h-full" x-data :class="{ 'dark': $store.theme.darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TaskOrbit') }} - Manajemen Tugas Profesional</title>
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Theme Script (No-flicker) -->
    <script>
        (function() {
            const theme = localStorage.getItem('color-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Alpine.js -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                darkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('color-theme', this.darkMode ? 'dark' : 'light');
                    window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: this.darkMode ? 'dark' : 'light' } }));
                }
            })
        })
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        [v-cloak] { display: none; }
    </style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-200 transition-colors duration-300">
    
    <!-- Navbar -->
    <nav class="glass-nav sticky top-0 z-50 border-b border-slate-200 dark:border-slate-800" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">TaskOrbit</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400' }}">Dashboard</a>
                        <a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('tasks.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400' }}">Tugas</a>
                        <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-slate-600 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400' }}">Kategori</a>
                        
                        <div class="w-px h-6 bg-slate-200 dark:border-slate-800"></div>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff&bold=true" class="w-8 h-8 rounded-full border border-white dark:border-slate-700" alt="Avatar">
                                <span class="text-sm font-semibold pr-2">{{ Auth::user()->name }}</span>
                            </button>
                            <!-- Dropdown -->
                            <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 mb-1 text-xs text-slate-500 uppercase font-bold tracking-wider">Akun Saya</div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 flex items-center">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary-600">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-xl text-sm font-bold shadow-lg shadow-primary-600/20 transition-all hover:-translate-y-0.5">Daftar Gratis</a>
                    @endguest

                    <button @click="$store.theme.toggle()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                        <i x-show="!$store.theme.darkMode" class="fa-solid fa-moon"></i>
                        <i x-show="$store.theme.darkMode" class="fa-solid fa-sun" x-cloak></i>
                    </button>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-2">
                    <button @click="$store.theme.toggle()" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i x-show="!$store.theme.darkMode" class="fa-solid fa-moon"></i>
                        <i x-show="$store.theme.darkMode" class="fa-solid fa-sun" x-cloak></i>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" class="md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-4 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-semibold {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600' : 'text-slate-600' }}">Dashboard</a>
                <a href="{{ route('tasks.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold {{ request()->routeIs('tasks.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600' }}">Tugas</a>
                <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold {{ request()->routeIs('categories.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600' }}">Kategori</a>
                <hr class="border-slate-200 dark:border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-base font-semibold text-red-600">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-slate-600">Masuk</a>
                <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-base font-semibold bg-primary-600 text-white text-center">Daftar Sekarang</a>
            @endguest
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">
        @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 animate-in fade-in slide-in-from-top-4 duration-500" role="alert">
                <i class="fa-solid fa-circle-check text-xl mr-3"></i>
                <div class="text-sm font-bold">{{ session('success') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="flex p-4 mb-6 text-red-800 rounded-2xl bg-red-50 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-800" role="alert">
                <i class="fa-solid fa-circle-exclamation text-xl mr-3 mt-0.5"></i>
                <div>
                    <span class="font-bold">Terjadi Kesalahan:</span>
                    <ul class="mt-1.5 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex flex-col items-center">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white text-xs">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">TaskOrbit</span>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto mb-8">Solusi manajemen tugas akademik paling modern untuk mahasiswa produktif masa kini.</p>
                <div class="flex space-x-6 mb-8 text-slate-400 dark:text-slate-500">
                    <a href="#" class="hover:text-primary-600 transition-colors"><i class="fa-brands fa-github text-xl"></i></a>
                    <a href="#" class="hover:text-primary-600 transition-colors"><i class="fa-brands fa-twitter text-xl"></i></a>
                    <a href="#" class="hover:text-primary-600 transition-colors"><i class="fa-brands fa-linkedin text-xl"></i></a>
                </div>
                <p class="text-slate-400 dark:text-slate-600 text-xs font-medium uppercase tracking-widest">&copy; {{ date('Y') }} TaskOrbit. Crafted for Excellence.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
