<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
</head>
<body class="min-h-screen bg-slate-50">
    {{-- Top navbar --}}
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media"
                     class="h-9 w-9 rounded-lg object-cover">
                <span class="text-lg font-bold text-slate-800">Astakira Media</span>
                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">PKL</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-medium text-slate-700">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->nisp ?? 'Tanpa NISP' }}</p>
                </div>
                <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200">
                    @if (auth()->user()->foto_profile)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="{{ auth()->user()->nama }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                            {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-red-50 hover:text-red-600">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Sidebar + Content --}}
    <div class="mx-auto flex max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:px-8 pb-24 lg:pb-8">
        <aside class="hidden w-56 shrink-0 lg:block">
            <nav class="space-y-1">
                <a href="{{ route('pkl.dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('pkl.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Dashboard
                </a>
                <a href="{{ route('pkl.absensi') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('pkl.absensi*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Absensi
                </a>
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    Laporan
                </a>
            </nav>
        </aside>

        {{-- Main content --}}
        <main class="min-w-0 flex-1">
            @yield('content')
        </main>
    </div>

    {{-- Bottom bar for mobile --}}
    <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-slate-200 bg-white shadow-lg lg:hidden">
        <div class="flex items-center justify-around px-2 py-2">
            <a href="{{ route('pkl.dashboard') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('pkl.dashboard') ? 'text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('pkl.absensi') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('pkl.absensi*') ? 'text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="calendar-check" class="h-5 w-5"></i>
                <span>Absensi</span>
            </a>
            <a href="#"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium text-slate-500 transition-colors">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                <span>Laporan</span>
            </a>
            <form action="{{ route('user.logout') }}" method="POST" class="flex flex-1 justify-center">
                @csrf
                <button type="submit"
                        class="flex flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium text-slate-500 transition-colors hover:text-red-600">
                    <i data-lucide="log-out" class="h-5 w-5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>
