@extends('pembimbing.layout')

@section('title', 'Dashboard Pembimbing')

@section('content')
    {{-- Welcome banner --}}
    <div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#0a1628] via-[#0d2b55] to-[#0b5ed7] p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat datang, {{ $pembimbing->nama }}!</h2>
                <p class="mt-1 text-sm text-slate-300">Pantau aktivitas anak PKL yang Anda bimbing.</p>
            </div>
            <div class="hidden h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur sm:flex">
                <i data-lucide="user-check" class="h-8 w-8 text-white"></i>
            </div>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Anak PKL</p>
                    <p class="mt-1 text-2xl font-bold text-primary-color">{{ $stats['total_anak'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50">
                    <i data-lucide="graduation-cap" class="h-5 w-5 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Hadir Hari Ini</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $stats['hadir_hari_ini'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50">
                    <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Izin/Sakit</p>
                    <p class="mt-1 text-2xl font-bold text-rose-500">{{ $stats['izin_sakit_hari_ini'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50">
                    <i data-lucide="file-warning" class="h-5 w-5 text-rose-500"></i>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-surface card-surface p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-secondary-color">Laporan Pending</p>
                    <p class="mt-1 text-2xl font-bold text-amber-600">{{ $stats['laporan_pending'] }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50">
                    <i data-lucide="clock" class="h-5 w-5 text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="mb-6 rounded-2xl border border-surface card-surface p-5 shadow-sm">
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-base font-semibold text-primary-color">Tren Absensi Anak PKL (7 Hari Terakhir)</h3>
                <p class="text-xs text-secondary-color">Statistik harian kehadiran dan izin/sakit</p>
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

    {{-- Status anak PKL hari ini --}}
    <div class="mb-6 rounded-2xl border border-surface card-surface shadow-sm">
        <div class="flex items-center justify-between border-b border-surface px-6 py-4">
            <h2 class="text-base font-semibold text-primary-color">Status Anak PKL Hari Ini</h2>
            <a href="{{ route('pembimbing.absensi.index') }}" class="text-sm font-medium text-brand-blue hover:text-deep-blue">Detail absensi</a>
        </div>
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface bg-[var(--color-surface-hover)]">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">NISP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Jam Keluar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($anakPkl as $anak)
                        @php
                            $absensi = $absensiHariIni->get($anak->id);
                            $izin = $izinHariIni->get($anak->id);
                            if ($izin) {
                                $statusLabel = ucfirst($izin->jenis);
                                $statusClass = 'bg-rose-100 text-rose-700';
                            } elseif ($absensi && $absensi->jam_masuk) {
                                $statusLabel = 'Hadir';
                                $statusClass = 'bg-emerald-100 text-emerald-700';
                            } else {
                                $statusLabel = 'Belum Absen';
                                $statusClass = 'bg-slate-100 text-slate-500';
                            }
                        @endphp
                        <tr class="transition-colors hover:bg-[var(--color-surface-hover)]">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($anak->foto_profile)
                                            <img src="{{ asset('storage/' . $anak->foto_profile) }}" alt="{{ $anak->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs font-medium text-secondary-color">
                                                {{ strtoupper(substr($anak->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-primary-color">{{ $anak->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $anak->nisp ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $absensi?->jam_masuk ? $absensi->jam_masuk->format('H:i') : '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $absensi?->jam_keluar ? $absensi->jam_keluar->format('H:i') : '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada anak PKL yang dibimbing.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($anakPkl as $anak)
                @php
                    $absensi = $absensiHariIni->get($anak->id);
                    $izin = $izinHariIni->get($anak->id);
                    if ($izin) {
                        $statusLabel = ucfirst($izin->jenis);
                        $statusClass = 'bg-rose-100 text-rose-700';
                    } elseif ($absensi && $absensi->jam_masuk) {
                        $statusLabel = 'Hadir';
                        $statusClass = 'bg-emerald-100 text-emerald-700';
                    } else {
                        $statusLabel = 'Belum Absen';
                        $statusClass = 'bg-slate-100 text-slate-500';
                    }
                @endphp
                <div class="p-4 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200 shrink-0">
                                @if ($anak->foto_profile)
                                    <img src="{{ asset('storage/' . $anak->foto_profile) }}" alt="{{ $anak->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs font-medium text-secondary-color">
                                        {{ strtoupper(substr($anak->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $anak->nama }}</p>
                                <p class="text-xs text-secondary-color mt-0.5">{{ $anak->nisp ?? 'Tanpa NISP' }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>
                    @if ($absensi && $absensi->jam_masuk)
                        <div class="flex items-center justify-between pt-2 border-t border-slate-50 text-xs">
                            <span class="text-secondary-color">Masuk: {{ $absensi->jam_masuk->format('H:i') }}</span>
                            <span class="text-secondary-color">Keluar: {{ $absensi?->jam_keluar ? $absensi->jam_keluar->format('H:i') : '-' }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada anak PKL yang dibimbing.</div>
            @endforelse
        </div>
    </div>

    {{-- Laporan terbaru --}}
    <div class="rounded-2xl border border-surface card-surface shadow-sm">
        <div class="flex items-center justify-between border-b border-surface px-6 py-4">
            <h2 class="text-base font-semibold text-primary-color">Laporan Terbaru</h2>
            <a href="{{ route('pembimbing.laporan.index') }}" class="text-sm font-medium text-brand-blue hover:text-deep-blue">Lihat semua</a>
        </div>
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface bg-[var(--color-surface-hover)]">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Anak PKL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-secondary-color">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($laporanTerbaru as $laporan)
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'validated' => 'bg-emerald-100 text-emerald-700',
                                'rejected' => 'bg-rose-100 text-rose-700',
                            ];
                            $statusLabel = [
                                'pending' => 'Pending',
                                'validated' => 'Divalidasi',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <tr class="transition-colors hover:bg-[var(--color-surface-hover)]">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary-color">{{ $laporan->user->nama }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-secondary-color">{{ $laporan->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-secondary-color max-w-xs truncate">{{ $laporan->keterangan }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$laporan->status] }}">{{ $statusLabel[$laporan->status] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($laporanTerbaru as $laporan)
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700',
                        'validated' => 'bg-emerald-100 text-emerald-700',
                        'rejected' => 'bg-rose-100 text-rose-700',
                    ];
                    $statusLabel = [
                        'pending' => 'Pending',
                        'validated' => 'Divalidasi',
                        'rejected' => 'Ditolak',
                    ];
                @endphp
                <div class="p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-800">{{ $laporan->user->nama }}</p>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusColors[$laporan->status] }}">{{ $statusLabel[$laporan->status] }}</span>
                    </div>
                    <p class="text-xs text-secondary-color">{{ $laporan->tanggal->format('d M Y') }}</p>
                    <p class="text-xs text-slate-600 line-clamp-2">{{ $laporan->keterangan }}</p>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-secondary-color">Belum ada laporan.</div>
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
                        borderColor: '#2563eb',
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
                        borderColor: '#f43f5e',
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
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        padding: 12,
                        cornerRadius: 12,
                        backgroundColor: '#1e293b',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        titleFont: { family: 'Inter, system-ui, sans-serif', size: 13, weight: 'bold' },
                        bodyFont: { family: 'Inter, system-ui, sans-serif', size: 12 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter, system-ui, sans-serif', size: 11 }, color: '#64748b' }
                    },
                    y: {
                        min: 0,
                        ticks: { stepSize: 1, font: { family: 'Inter, system-ui, sans-serif', size: 11 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    });
</script>
@endpush
