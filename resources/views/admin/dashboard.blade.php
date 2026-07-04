@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Welcome banner --}}
    <div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#0a1628] via-[#0d2b55] to-[#0b5ed7] p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat datang, {{ $user->nama }}!</h2>
                <p class="mt-1 text-sm text-slate-300">Berikut ringkasan aktivitas sistem absensi hari ini.</p>
            </div>
            <div class="hidden h-16 w-16 items-center justify-center rounded-2xl card-surface/10 backdrop-blur sm:flex">
                <i data-lucide="layout-dashboard" class="h-8 w-8 text-white"></i>
            </div>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Total Pengguna</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_users'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-50">
                    <i data-lucide="users" class="h-5 w-5 text-brand-blue"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Admin</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_admin'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50">
                    <i data-lucide="shield-check" class="h-5 w-5 text-indigo-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Karyawan</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_karyawan'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50">
                    <i data-lucide="briefcase" class="h-5 w-5 text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">PKL</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_pkl'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50">
                    <i data-lucide="graduation-cap" class="h-5 w-5 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Pembimbing</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_pembimbing'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50">
                    <i data-lucide="user-check" class="h-5 w-5 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.users.create') }}" class="group flex items-center gap-3 rounded-xl border border-surface card-surface p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50 transition-colors group-hover:bg-primary-100">
                <i data-lucide="user-plus" class="h-5 w-5 text-brand-blue"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-primary-color">Tambah Pengguna</p>
                <p class="text-xs text-secondary-color">Daftarkan akun baru</p>
            </div>
        </a>
        <a href="{{ route('admin.absensi.index') }}" class="group flex items-center gap-3 rounded-xl border border-surface card-surface p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 transition-colors group-hover:bg-emerald-100">
                <i data-lucide="calendar-check" class="h-5 w-5 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-primary-color">Lihat Absensi</p>
                <p class="text-xs text-secondary-color">Data kehadiran</p>
            </div>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-3 rounded-xl border border-surface card-surface p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 transition-colors group-hover:bg-amber-100">
                <i data-lucide="file-text" class="h-5 w-5 text-amber-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-primary-color">Laporan</p>
                <p class="text-xs text-secondary-color">Validasi laporan PKL</p>
            </div>
        </a>
        <a href="{{ route('admin.pembimbing.index') }}" class="group flex items-center gap-3 rounded-xl border border-surface card-surface p-4 shadow-sm transition-all hover:border-primary-300 hover:shadow-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 transition-colors group-hover:bg-purple-100">
                <i data-lucide="user-check" class="h-5 w-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-primary-color">Pembimbing</p>
                <p class="text-xs text-secondary-color">Kelola pembimbing</p>
            </div>
        </a>
    </div>

    {{-- Chart Section --}}
    <div class="mb-6 rounded-2xl border border-surface card-surface p-5 shadow-sm">
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-primary-color">Tren Aktivitas Absensi (7 Hari Terakhir)</h3>
                <p class="text-xs text-secondary-color">Statistik harian absensi dan pengajuan izin/sakit</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-secondary-color">
                    <span class="h-3 w-3 rounded-full bg-brand-blue"></span>
                    Kehadiran
                </span>
                <span class="flex items-center gap-1.5 text-secondary-color">
                    <span class="h-3 w-3 rounded-full bg-rose-500"></span>
                    Izin/Sakit
                </span>
            </div>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    {{-- Recent users --}}
    <div class="rounded-2xl border border-surface card-surface shadow-sm">
        <div class="flex items-center justify-between border-b border-surface px-6 py-4">
            <h2 class="text-base font-semibold text-primary-color">Pengguna Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand-blue hover:text-deep-blue">Lihat semua</a>
        </div>
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface bg-[var(--color-surface-hover)]">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">NISP</th>
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
                        <tr class="transition-colors hover:bg-[var(--color-surface-hover)]">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($item->foto_profile)
                                            <img src="{{ asset('storage/' . $item->foto_profile) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs font-medium text-secondary-color">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-primary-color">{{ $item->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $item->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $roleColors[$item->role] ?? 'bg-[var(--color-surface-hover)] text-primary-color' }}">
                                    {{ $roleLabel[$item->role] ?? $item->role }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $item->nisp ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="block md:hidden divide-y divide-slate-100">
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
                <div class="p-4 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200 shrink-0">
                                @if ($item->foto_profile)
                                    <img src="{{ asset('storage/' . $item->foto_profile) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs font-medium text-secondary-color">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->nama }}</p>
                                <p class="text-xs text-secondary-color mt-0.5 truncate">{{ $item->email }}</p>
                            </div>
                        </div>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $roleColors[$item->role] ?? 'bg-[var(--color-surface-hover)] text-primary-color' }}">
                            {{ $roleLabel[$item->role] ?? $item->role }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50 text-xs">
                        <span class="text-secondary-color">NISP:</span>
                        <span class="font-medium text-primary-color">{{ $item->nisp ?? '-' }}</span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada pengguna terdaftar.</div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        
        const labels = @json($chartLabels);
        const dataHadir = @json($chartHadir);
        const dataIzin = @json($chartIzin);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Kehadiran',
                        data: dataHadir,
                        borderColor: '#2563eb', // brand-blue
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Izin/Sakit',
                        data: dataIzin,
                        borderColor: '#f43f5e', // rose-500
                        backgroundColor: 'rgba(244, 63, 94, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#f43f5e',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        padding: 12,
                        cornerRadius: 12,
                        backgroundColor: '#1e293b',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        titleFont: {
                            family: 'Inter, system-ui, sans-serif',
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Inter, system-ui, sans-serif',
                            size: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif',
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    y: {
                        min: 0,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Inter, system-ui, sans-serif',
                                size: 11
                            },
                            color: '#64748b'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
