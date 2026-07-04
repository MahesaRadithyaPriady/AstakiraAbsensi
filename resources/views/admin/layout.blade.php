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
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 flex w-60 flex-col bg-navy transition-transform duration-300 lg:translate-x-0 -translate-x-full" id="admin-sidebar">
            {{-- Logo --}}
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
                <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media" class="h-9 w-9 rounded-lg object-cover">
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">Astakira Media</p>
                    <p class="text-xs text-slate-400">Admin Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">Menu</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.dashboard') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.users.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    Pengguna
                </a>
                <a href="{{ route('admin.pembimbing.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.pembimbing.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="user-check" class="h-4 w-4"></i>
                    Pembimbing
                </a>
                <a href="{{ route('admin.absensi.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.absensi.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Absensi
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.laporan.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    Laporan
                </a>
                <p class="px-3 pt-4 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">Sistem</p>
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
                        <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('administrator.logout') }}" method="POST">
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
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-navy/60 lg:hidden" onclick="document.getElementById('admin-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')"></div>

        {{-- Main area --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-60">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('admin-sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('hidden')" class="lg:hidden">
                        <i data-lucide="menu" class="h-5 w-5 text-slate-600"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-navy">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-medium text-slate-700">{{ auth()->user()->nama }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
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
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
