@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-10 md:p-14">
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <i class="fa-solid fa-right-to-bracket text-3xl"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight mb-2">Selamat Datang Kembali</h3>
                <p class="text-slate-500 dark:text-slate-400 font-medium">Masuk untuk mengelola tugas-tugas Anda</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="w-full pl-12 pr-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Kata Sandi</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="w-full pl-12 pr-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-primary-500 transition-all font-medium" placeholder="••••••••" required>
                    </div>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-primary-600 hover:bg-primary-700 text-white font-black rounded-2xl shadow-xl shadow-primary-600/20 transition-all hover:-translate-y-1 text-lg">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
            
            <div class="mt-10 text-center">
                <p class="text-slate-500 dark:text-slate-400 font-medium">Belum memiliki akun? <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400 font-bold hover:underline">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
