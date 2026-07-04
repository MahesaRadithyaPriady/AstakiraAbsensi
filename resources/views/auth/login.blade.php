<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name') }}</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            {{-- Card --}}
            <div class="rounded-2xl bg-white shadow-xl shadow-blue-500/10 overflow-hidden">
                {{-- Top accent bar --}}
                <div class="h-1.5 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700"></div>

                {{-- Body --}}
                <div class="px-8 py-10">
                    {{-- Header --}}
                    <div class="mb-8 text-center">
                        <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media"
                             class="mx-auto mb-4 h-20 w-20 rounded-2xl object-cover shadow-md ring-4 ring-blue-50">
                        <h1 class="text-2xl font-bold text-slate-800">Login Pengguna</h1>
                        <p class="mt-1 text-sm text-slate-500">Sistem Absensi Astakira Media</p>
                    </div>

                    {{-- Form --}}
                    <form action="{{ url('/login') }}" method="POST" class="space-y-5">
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
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-slate-800 placeholder-slate-400 transition-all focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:outline-none @error('email') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                    placeholder="email@astakiramedia.com"
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
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-12 text-slate-800 placeholder-slate-400 transition-all focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 focus:outline-none @error('password') border-red-400 focus:border-red-400 focus:ring-red-100 @enderror"
                                    placeholder="••••••••"
                                    required
                                >
                                <button type="button" id="toggle-password"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-blue-500 focus:outline-none">
                                    <i data-lucide="eye" class="h-5 w-5" id="eye-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 py-3.5 text-base font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-700 hover:to-blue-800 hover:shadow-blue-600/40 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span>Masuk</span>
                            <i data-lucide="arrow-right" class="h-5 w-5"></i>
                        </button>
                    </form>

                    {{-- Footer --}}
                    <p class="mt-8 text-center text-xs text-slate-400">
                        &copy; {{ date('Y') }} Astakira Media. All rights reserved.<br>
                        <a href="{{ url('/administrator/login') }}" class="text-blue-500 hover:text-blue-700">Login Admin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
