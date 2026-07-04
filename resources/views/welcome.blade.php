<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Absensi Astakira Media') }}</title>

        @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
    </head>
    <body class="min-h-screen bg-off-white font-sans">
        <div class="flex min-h-screen">
            {{-- Brand panel --}}
            <div class="hidden lg:flex lg:w-1/2 items-center justify-center bg-gradient-to-br from-navy via-deep-blue to-brand-blue p-12">
                <div class="max-w-md text-white">
                    <div class="mb-8 flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur">
                            <i data-lucide="fingerprint" class="h-7 w-7 text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Astakira Media</span>
                    </div>
                    <h1 class="text-4xl font-bold leading-tight">Sistem Absensi PKL</h1>
                    <p class="mt-4 text-lg text-slate-300">Platform manajemen kehadiran dan laporan kegiatan PKL yang modern dan efisien.</p>
                    <div class="mt-8 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="qr-code" class="h-4 w-4 text-white"></i>
                            </div>
                            <span class="text-sm text-slate-300">Absensi QR Code real-time</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="file-text" class="h-4 w-4 text-white"></i>
                            </div>
                            <span class="text-sm text-slate-300">Laporan kegiatan harian</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="users" class="h-4 w-4 text-white"></i>
                            </div>
                            <span class="text-sm text-slate-300">Manajemen pembimbing PKL</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Login/action panel --}}
            <div class="flex w-full lg:w-1/2 items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-sm">
                    <div class="mb-8 text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-blue shadow-lg shadow-primary-500/30">
                            <i data-lucide="fingerprint" class="h-8 w-8 text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-navy">Selamat Datang</h2>
                        <p class="mt-1 text-sm text-slate-500">Silakan masuk untuk melanjutkan</p>
                    </div>

                    @if (Route::has('user.login') && Route::has('login'))
                        <div class="space-y-3">
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                @elseif (auth()->user()->isPkl())
                                    <a href="{{ route('pkl.dashboard') }}"
                                       class="flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                                        <span>Dashboard PKL</span>
                                    </a>
                                @elseif (auth()->user()->isPembimbing())
                                    <a href="{{ route('pembimbing.dashboard') }}"
                                       class="flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                                        <span>Dashboard Pembimbing</span>
                                    </a>
                                @else
                                    <a href="{{ route('settings.index') }}"
                                       class="flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                                        <span>Dashboard</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('user.login') }}"
                                   class="flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                    <i data-lucide="log-in" class="h-4 w-4"></i>
                                    <span>Login Pengguna</span>
                                </a>
                                <a href="{{ route('login') }}"
                                   class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-navy transition hover:border-brand-blue hover:bg-primary-50">
                                    <i data-lucide="shield" class="h-4 w-4"></i>
                                    <span>Login Admin</span>
                                </a>
                            @endauth
                        </div>
                    @endif

                    <p class="mt-8 text-center text-xs text-slate-400">
                        &copy; {{ date('Y') }} Astakira Media. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
