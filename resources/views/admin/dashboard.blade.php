@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Welcome banner --}}
    <div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-navy via-deep-blue to-brand-blue p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat datang, {{ $user->nama }}!</h2>
                <p class="mt-1 text-sm text-slate-300">Berikut ringkasan aktivitas sistem absensi hari ini.</p>
            </div>
            <div class="hidden h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur sm:flex">
                <i data-lucide="layout-dashboard" class="h-8 w-8 text-white"></i>
            </div>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Total Pengguna</p>
                    <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total_users'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-50">
                    <i data-lucide="users" class="h-5 w-5 text-brand-blue"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Admin</p>
                    <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total_admin'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50">
                    <i data-lucide="shield-check" class="h-5 w-5 text-indigo-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Karyawan</p>
                    <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total_karyawan'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50">
                    <i data-lucide="briefcase" class="h-5 w-5 text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">PKL</p>
                    <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total_pkl'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50">
                    <i data-lucide="graduation-cap" class="h-5 w-5 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Pembimbing</p>
                    <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total_pembimbing'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50">
                    <i data-lucide="user-check" class="h-5 w-5 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.users.create') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50 transition-colors group-hover:bg-primary-100">
                <i data-lucide="user-plus" class="h-5 w-5 text-brand-blue"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Tambah Pengguna</p>
                <p class="text-xs text-slate-400">Daftarkan akun baru</p>
            </div>
        </a>
        <a href="{{ route('admin.absensi.index') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 transition-colors group-hover:bg-emerald-100">
                <i data-lucide="calendar-check" class="h-5 w-5 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Lihat Absensi</p>
                <p class="text-xs text-slate-400">Data kehadiran</p>
            </div>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 transition-colors group-hover:bg-amber-100">
                <i data-lucide="file-text" class="h-5 w-5 text-amber-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Laporan</p>
                <p class="text-xs text-slate-400">Validasi laporan PKL</p>
            </div>
        </a>
        <a href="{{ route('admin.pembimbing.index') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 transition-colors group-hover:bg-purple-100">
                <i data-lucide="user-check" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Pembimbing</p>
                <p class="text-xs text-slate-400">Kelola pembimbing</p>
            </div>
        </a>
    </div>

    {{-- Recent users --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Pengguna Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand-blue hover:text-deep-blue">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NISP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recent_users as $item)
                        @php
                            $roleColors = [
                                'admin' => 'bg-indigo-100 text-indigo-700',
                                'karyawan' => 'bg-emerald-100 text-emerald-700',
                                'pkl' => 'bg-amber-100 text-amber-700',
                                'pembimbing' => 'bg-purple-100 text-purple-700',
                            ];
                            $roleLabel = [
                                'admin' => 'Admin',
                                'karyawan' => 'Karyawan',
                                'pkl' => 'PKL',
                                'pembimbing' => 'Pembimbing',
                            ];
                        @endphp
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($item->foto_profile)
                                            <img src="{{ asset('storage/' . $item->foto_profile) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $item->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $item->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $roleColors[$item->role] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $roleLabel[$item->role] ?? $item->role }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $item->nisp ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
