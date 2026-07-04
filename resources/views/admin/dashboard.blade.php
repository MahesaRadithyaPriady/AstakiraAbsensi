@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500">Selamat datang kembali, {{ $user->nama }}!</p>
    </div>

    {{-- Stats cards --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Total Pengguna</p>
                    <p class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['total_users'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50">
                    <i data-lucide="users" class="h-5 w-5 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Admin</p>
                    <p class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['total_admin'] }}</p>
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
                    <p class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['total_karyawan'] }}</p>
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
                    <p class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['total_pkl'] }}</p>
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
                    <p class="mt-1 text-2xl font-bold text-slate-800">{{ $stats['total_pembimbing'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50">
                    <i data-lucide="user-check" class="h-5 w-5 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.users.create') }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 transition-colors group-hover:bg-blue-100">
                <i data-lucide="user-plus" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Tambah Pengguna</p>
                <p class="text-xs text-slate-400">Daftarkan akun baru</p>
            </div>
        </a>
        <a href="#" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 transition-colors group-hover:bg-emerald-100">
                <i data-lucide="calendar-check" class="h-5 w-5 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Lihat Absensi</p>
                <p class="text-xs text-slate-400">Data kehadiran</p>
            </div>
        </a>
        <a href="#" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 transition-colors group-hover:bg-amber-100">
                <i data-lucide="file-text" class="h-5 w-5 text-amber-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Laporan</p>
                <p class="text-xs text-slate-400">Generate laporan</p>
            </div>
        </a>
        <a href="#" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 transition-colors group-hover:bg-purple-100">
                <i data-lucide="settings" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Pengaturan</p>
                <p class="text-xs text-slate-400">Konfigurasi sistem</p>
            </div>
        </a>
    </div>

    {{-- Recent users --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-800">Pengguna Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat semua</a>
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
