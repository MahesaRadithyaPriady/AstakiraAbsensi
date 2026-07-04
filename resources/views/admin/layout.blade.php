<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('astakira.jpg') }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])

    <script>
        (function() {
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 hidden lg:flex sidebar-width flex-col sidebar-surface overflow-hidden" id="admin-sidebar">
            {{-- Logo --}}
            <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5 sidebar-logo">
                <img src="{{ asset('astakira.jpg') }}" alt="Astakira Media" class="h-9 w-9 rounded-lg object-cover shrink-0">
                <div class="min-w-0 sidebar-label">
                    <p class="truncate text-sm font-bold text-white">Astakira Media</p>
                    <p class="text-xs text-slate-400">Admin Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 space-y-1 overflow-y-auto overflow-x-hidden px-3 py-4">
                <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500 sidebar-label">Menu</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.dashboard') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.users.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="users" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Pengguna</span>
                </a>
                <a href="{{ route('admin.pembimbing.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.pembimbing.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="user-check" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Pembimbing</span>
                </a>
                <a href="{{ route('admin.absensi.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.absensi.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="calendar-check" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Absensi</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.laporan.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Laporan</span>
                </a>
                <a href="{{ route('admin.sop.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('admin.sop.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="clipboard-list" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">SOP PKL</span>
                </a>
                <p class="px-3 pt-4 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500 sidebar-label">Sistem</p>
                <a href="{{ route('settings.index') }}"
                   class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                   {{ request()->routeIs('settings.*') ? 'bg-brand-blue text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="settings" class="h-4 w-4 shrink-0"></i>
                    <span class="sidebar-label">Pengaturan</span>
                </a>
            </nav>

            {{-- User card at bottom --}}
            <div class="border-t border-white/10 p-3">
                <div class="sidebar-nav-item flex items-center gap-3 rounded-lg px-3 py-2">
                    <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full bg-white/10">
                        @if (auth()->user()->foto_profile)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="{{ auth()->user()->nama }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-300">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 sidebar-label">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->nama }}</p>
                        <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('administrator.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="sidebar-nav-item mt-2 flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 transition-colors hover:bg-red-500/10 hover:text-red-400">
                        <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                        <span class="sidebar-label">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main area --}}
        <div class="main-area flex min-w-0 flex-1 flex-col">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between card-surface px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button id="sidebar-toggle" type="button" class="hidden lg:flex text-secondary-color hover:bg-white/10 dark:hover:bg-black/10 focus:outline-none rounded-lg text-sm p-2.5">
                        <span id="sidebar-expand-icon" class="hidden"><i data-lucide="chevrons-right" class="h-5 w-5"></i></span>
                        <span id="sidebar-collapse-icon" class="hidden"><i data-lucide="chevrons-left" class="h-5 w-5"></i></span>
                    </button>
                    <h1 class="text-lg font-semibold text-primary-color">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <button id="theme-toggle" type="button" class="text-secondary-color hover:bg-white/10 dark:hover:bg-black/10 focus:outline-none rounded-lg text-sm p-2.5">
                        <span id="theme-toggle-dark-icon" class="hidden"><i data-lucide="moon" class="w-5 h-5"></i></span>
                        <span id="theme-toggle-light-icon" class="hidden"><i data-lucide="sun" class="w-5 h-5"></i></span>
                    </button>
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
            <main class="flex-1 p-4 pb-24 sm:p-6 sm:pb-28 lg:p-8 lg:pb-8">
                @yield('content')
            </main>
        </div>

        {{-- Bottom Navigation for Mobile --}}
        <nav class="fixed bottom-0 left-0 right-0 z-40 card-surface shadow-lg lg:hidden">
            {{-- Expandable "Lainnya" panel --}}
            <div id="more-panel" class="border-b border-slate-200 px-4">
                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('admin.pembimbing.index') }}"
                       class="flex flex-col items-center gap-1.5 rounded-xl px-2 py-3 text-xs font-medium transition-colors
                       {{ request()->routeIs('admin.pembimbing.*') ? 'bg-primary-50 text-brand-blue' : 'text-slate-600 hover:bg-slate-100' }}">
                        <i data-lucide="user-check" class="h-5 w-5"></i>
                        <span>Pembimbing</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}"
                       class="flex flex-col items-center gap-1.5 rounded-xl px-2 py-3 text-xs font-medium transition-colors
                       {{ request()->routeIs('admin.laporan.*') ? 'bg-primary-50 text-brand-blue' : 'text-slate-600 hover:bg-slate-100' }}">
                        <i data-lucide="file-text" class="h-5 w-5"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.sop.index') }}"
                       class="flex flex-col items-center gap-1.5 rounded-xl px-2 py-3 text-xs font-medium transition-colors
                       {{ request()->routeIs('admin.sop.*') ? 'bg-primary-50 text-brand-blue' : 'text-slate-600 hover:bg-slate-100' }}">
                        <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                        <span>SOP PKL</span>
                    </a>
                    <a href="{{ route('settings.index') }}"
                       class="flex flex-col items-center gap-1.5 rounded-xl px-2 py-3 text-xs font-medium transition-colors
                       {{ request()->routeIs('settings.*') ? 'bg-primary-50 text-brand-blue' : 'text-slate-600 hover:bg-slate-100' }}">
                        <i data-lucide="settings" class="h-5 w-5"></i>
                        <span>Setelan</span>
                    </a>
                    <form action="{{ route('administrator.logout') }}" method="POST" class="flex flex-col items-center">
                        @csrf
                        <button type="submit"
                                class="flex flex-col items-center gap-1.5 rounded-xl px-2 py-3 text-xs font-medium text-slate-600 transition-colors hover:bg-red-50 hover:text-red-600 w-full">
                            <i data-lucide="log-out" class="h-5 w-5"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Main 4 tabs --}}
            <div class="flex items-center justify-around px-2 py-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
                   {{ request()->routeIs('admin.dashboard') ? 'text-brand-blue' : 'text-slate-500' }}">
                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
                   {{ request()->routeIs('admin.users.*') ? 'text-brand-blue' : 'text-slate-500' }}">
                    <i data-lucide="users" class="h-5 w-5"></i>
                    <span>Pengguna</span>
                </a>
                <a href="{{ route('admin.absensi.index') }}"
                   class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
                   {{ request()->routeIs('admin.absensi.*') ? 'text-brand-blue' : 'text-slate-500' }}">
                    <i data-lucide="calendar-check" class="h-5 w-5"></i>
                    <span>Absensi</span>
                </a>
                <button type="button" id="more-toggle"
                        class="flex flex-1 flex-col items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium transition-colors
                        {{ request()->routeIs('admin.pembimbing.*') || request()->routeIs('admin.laporan.*') || request()->routeIs('admin.sop.*') || request()->routeIs('settings.*') ? 'text-brand-blue' : 'text-slate-500' }}">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                    <span>Lainnya</span>
                </button>
            </div>
        </nav>
    </div>

    @stack('scripts')
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            document.documentElement.classList.add('dark');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            document.documentElement.classList.remove('dark');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        // Sidebar collapse toggle
        var sidebarToggle = document.getElementById('sidebar-toggle');
        var sidebarExpandIcon = document.getElementById('sidebar-expand-icon');
        var sidebarCollapseIcon = document.getElementById('sidebar-collapse-icon');

        // Bottom nav "Lainnya" panel toggle
        var moreToggle = document.getElementById('more-toggle');
        var morePanel = document.getElementById('more-panel');

        moreToggle.addEventListener('click', function() {
            morePanel.classList.toggle('show');
        });

        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
            sidebarExpandIcon.classList.remove('hidden');
        } else {
            sidebarCollapseIcon.classList.remove('hidden');
        }

        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
            var collapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', collapsed);
            sidebarExpandIcon.classList.toggle('hidden');
            sidebarCollapseIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>
