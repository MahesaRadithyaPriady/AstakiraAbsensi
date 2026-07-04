<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
</head>
<body class="min-h-screen bg-off-white">
    <div class="flex min-h-screen">
        {{-- Sidebar (desktop) --}}
        <aside class="fixed inset-y-0 left-0 z-50 flex w-60 flex-col bg-navy transition-transform duration-300 lg:translate-x-0 -translate-x-full" id="pkl-sidebar">
            {{-- Logo --}}
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
                <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media" class="h-9 w-9 rounded-lg object-cover">
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">Astakira Media</p>
                    <p class="text-xs text-slate-400">PKL Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">Menu</p>
                <a href="{{ route('pkl.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('pkl.dashboard') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Dashboard
                </a>
                <a href="{{ route('pkl.absensi') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('pkl.absensi*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Absensi
                </a>
                <a href="{{ route('pkl.laporan') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('pkl.laporan*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    Laporan
                </a>
                <a href="{{ route('settings.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('settings.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="settings" class="h-4 w-4"></i>
                    Pengaturan
                </a>
            </nav>

            {{-- User card at bottom --}}
            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 rounded-lg px-3 py-2">
                    <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full bg-white/10">
                        @if (auth()->user()->foto_profile)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="{{ auth()->user()->nama }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-300">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->nama }}</p>
                        <p class="truncate text-xs text-slate-400">{{ auth()->user()->nisp ?? 'Tanpa NISP' }}</p>
                    </div>
                </div>
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="mt-2 flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 transition-colors hover:bg-red-500/10 hover:text-red-400">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-navy/60 lg:hidden" onclick="document.getElementById('pkl-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')"></div>

        {{-- Main area --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-60">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('pkl-sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('hidden')" class="lg:hidden">
                        <i data-lucide="menu" class="h-5 w-5 text-slate-600"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-navy">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
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
                </div>
            </header>

            {{-- Main content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Bottom nav for mobile --}}
    <nav class="fixed bottom-0 left-0 right-0 z-40 border-t border-slate-200 bg-white shadow-lg lg:hidden">
        <div class="flex items-center justify-around px-2 py-2">
            <a href="{{ route('pkl.dashboard') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('pkl.dashboard') ? 'text-brand-blue' : 'text-slate-500' }}">
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('pkl.absensi') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('pkl.absensi*') ? 'text-brand-blue' : 'text-slate-500' }}">
                <i data-lucide="calendar-check" class="h-5 w-5"></i>
                <span>Absensi</span>
            </a>
            <a href="{{ route('pkl.laporan') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('pkl.laporan*') ? 'text-brand-blue' : 'text-slate-500' }}">
                <i data-lucide="file-text" class="h-5 w-5"></i>
                <span>Laporan</span>
            </a>
            <a href="{{ route('settings.index') }}"
               class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
               {{ request()->routeIs('settings.*') ? 'text-brand-blue' : 'text-slate-500' }}">
                <i data-lucide="settings" class="h-5 w-5"></i>
                <span>Pengaturan</span>
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
