<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Administrator - {{ config('app.name') }}</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
</head>
<body class="min-h-screen bg-off-white">
    <div class="flex min-h-screen">
        {{-- Brand panel --}}
        <div class="relative hidden w-1/2 flex-col justify-between bg-navy p-12 lg:flex">
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-deep-blue to-brand-blue opacity-90"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media" class="h-12 w-12 rounded-xl object-cover shadow-lg">
                    <div>
                        <p class="text-lg font-bold text-white">Astakira Media</p>
                        <p class="text-sm text-slate-400">Sistem Absensi</p>
                    </div>
                </div>
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold leading-tight text-white">Admin Panel</h1>
                <p class="mt-3 max-w-sm text-slate-300">Kelola pengguna, absensi, dan laporan PKL dengan mudah dalam satu platform terpadu.</p>
                <div class="mt-8 flex items-center gap-6">
                    <div>
                        <p class="text-2xl font-bold text-white">100%</p>
                        <p class="text-xs text-slate-400">Digital</p>
                    </div>
                    <div class="h-8 w-px bg-white/20"></div>
                    <div>
                        <p class="text-2xl font-bold text-white">24/7</p>
                        <p class="text-xs text-slate-400">Akses</p>
                    </div>
                    <div class="h-8 w-px bg-white/20"></div>
                    <div>
                        <p class="text-2xl font-bold text-white">Real-time</p>
                        <p class="text-xs text-slate-400">Monitoring</p>
                    </div>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Astakira Media. All rights reserved.</p>
            </div>
        </div>

        {{-- Form panel --}}
        <div class="flex w-full items-center justify-center px-4 py-12 lg:w-1/2">
            <div class="w-full max-w-md">
                {{-- Mobile logo --}}
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media" class="h-12 w-12 rounded-xl object-cover shadow-md">
                    <div>
                        <p class="text-lg font-bold text-navy">Astakira Media</p>
                        <p class="text-sm text-slate-400">Admin Panel</p>
                    </div>
                </div>

                {{-- Header --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-navy">Selamat Datang</h2>
                    <p class="mt-1 text-sm text-slate-500">Masuk ke akun administrator Anda</p>
                </div>

                {{-- Form --}}
                <form action="{{ url('/administrator/login') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i data-lucide="mail" class="h-5 w-5"></i>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('email') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                placeholder="mahesa@astakiramedia.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i data-lucide="lock" class="h-5 w-5"></i>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-12 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('password') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-brand-blue focus:outline-none">
                                <i data-lucide="eye" class="h-5 w-5" id="eye-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-blue py-3.5 text-base font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue hover:shadow-primary-600/40 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-brand-blue focus:ring-offset-2">
                        <span>Masuk</span>
                        <i data-lucide="arrow-right" class="h-5 w-5"></i>
                    </button>
                </form>

                {{-- Footer --}}
                <p class="mt-8 text-center text-xs text-slate-400">
                    &copy; {{ date('Y') }} Astakira Media. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
