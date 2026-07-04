@extends('admin.layout')

@section('title', 'Absensi & Izin/Sakit')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-navy">Absensi & Izin/Sakit</h1>
        <p class="mt-1 text-sm text-slate-500">Rekap absensi dan pengajuan izin/sakit PKL</p>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="check-circle" class="h-4 w-4"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Date picker --}}
    <div class="mb-6 flex items-center gap-3">
        <form method="GET" action="{{ route('admin.absensi.index') }}" class="flex items-center gap-3">
            <label class="text-sm font-medium text-slate-600">Tanggal:</label>
            <input type="date" name="tanggal" value="{{ $selectedDate }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-800 focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-blue px-4 py-2 text-sm font-medium text-white hover:bg-deep-blue">
                <i data-lucide="search" class="h-4 w-4"></i> Filter
            </button>
            @if (request('tanggal'))
                <a href="{{ route('admin.absensi.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Summary cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50">
                    <i data-lucide="users" class="h-5 w-5 text-brand-blue"></i>
                </div>
                <div><p class="text-xs font-medium text-slate-400">Total PKL</p><p class="text-lg font-bold text-navy">{{ $pklUsers->count() }}</p></div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                    <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                </div>
                <div><p class="text-xs font-medium text-slate-400">Hadir</p><p class="text-lg font-bold text-emerald-700">{{ $hadir }}</p></div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                    <i data-lucide="clock" class="h-5 w-5 text-amber-600"></i>
                </div>
                <div><p class="text-xs font-medium text-slate-400">Belum Absen</p><p class="text-lg font-bold text-amber-700">{{ $belumAbsen }}</p></div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                    <i data-lucide="file-text" class="h-5 w-5 text-purple-600"></i>
                </div>
                <div><p class="text-xs font-medium text-slate-400">Izin/Sakit</p><p class="text-lg font-bold text-purple-700">{{ $izinSakitCount }}</p></div>
            </div>
        </div>
    </div>

    {{-- Absensi harian per PKL --}}
    <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Absensi {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</h2>
            <i data-lucide="calendar-check" class="h-5 w-5 text-slate-400"></i>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">PKL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NISP</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500">Jam Masuk</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pklUsers as $user)
                        @php $absen = $absensisToday->get($user->id); $izin = $izinSakitsToday->get($user->id); @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($user->foto_profile)<img src="{{ asset('storage/' . $user->foto_profile) }}" class="h-full w-full object-cover">@else<div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>@endif
                                    </div>
                                    <p class="text-sm font-medium text-slate-700">{{ $user->nama }}</p>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $user->nisp ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-slate-600">{{ $absen && $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') . ' WIB' : '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                @if ($izin)<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $izin->jenis === 'sakit' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($izin->jenis) }}</span>
                                @elseif ($absen && $absen->jam_masuk)<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Hadir</span>
                                @else<span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-500">Belum Absen</span>@endif
                            </td>
                        </tr>
                    @empty<tr><td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada PKL terdaftar.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Absensi --}}
    <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Riwayat Absensi</h2>
            <form method="GET" action="{{ route('admin.absensi.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NISP..." class="w-48 rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-200"><i data-lucide="search" class="h-3.5 w-3.5"></i></button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">PKL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500">Jam Masuk</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($allAbsensis as $absensi)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($absensi->user->foto_profile)<img src="{{ asset('storage/' . $absensi->user->foto_profile) }}" class="h-full w-full object-cover">@else<div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">{{ strtoupper(substr($absensi->user->nama, 0, 1)) }}</div>@endif
                                    </div>
                                    <div><p class="text-sm font-medium text-slate-700">{{ $absensi->user->nama }}</p><p class="text-xs text-slate-400">{{ $absensi->user->nisp ?? '-' }}</p></div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $absensi->tanggal->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm">@if ($absensi->jam_masuk)<span class="font-medium text-emerald-600">{{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }} WIB</span>@else<span class="text-slate-400">Belum scan</span>@endif</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <form action="{{ route('admin.absensi.destroy', $absensi) }}" method="POST" onsubmit="return confirm('Hapus data absensi ini?')">@csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-100"><i data-lucide="trash-2" class="h-4 w-4"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty<tr><td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada data absensi.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        @if ($allAbsensis->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $allAbsensis->appends(request()->query())->links() }}</div>@endif
    </div>

    {{-- Pengajuan Izin/Sakit --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Pengajuan Izin/Sakit</h2>
            <form method="GET" action="{{ route('admin.absensi.index') }}" class="flex items-center gap-2" id="izin-filter">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <select name="status_izin" onchange="document.getElementById('izin-filter').submit()" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status_izin') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status_izin') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status_izin') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <select name="jenis_izin" onchange="document.getElementById('izin-filter').submit()" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                    <option value="">Semua Jenis</option>
                    <option value="izin" {{ request('jenis_izin') === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('jenis_izin') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Surat</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($izinSakits as $izin)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($izin->user->foto_profile)<img src="{{ asset('storage/' . $izin->user->foto_profile) }}" class="h-full w-full object-cover">@else<div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">{{ strtoupper(substr($izin->user->nama, 0, 1)) }}</div>@endif
                                    </div>
                                    <div><p class="text-sm font-medium text-slate-700">{{ $izin->user->nama }}</p><p class="text-xs text-slate-400">{{ $izin->user->nisp ?? '-' }}</p></div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $izin->jenis === 'sakit' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($izin->jenis) }}</span></td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $izin->tanggal->format('d M Y') }}@if ($izin->sampai_tanggal)<br><span class="text-slate-400">s/d</span> {{ $izin->sampai_tanggal->format('d M Y') }}@endif</td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $izin->keterangan }}</td>
                            <td class="whitespace-nowrap px-6 py-4">@if ($izin->surat)<a href="{{ asset('storage/' . $izin->surat) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-blue hover:text-deep-blue"><i data-lucide="file" class="h-4 w-4"></i> Lihat</a>@else<span class="text-xs text-slate-400">-</span>@endif</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $izin->status_approval === 'pending' ? 'bg-amber-100 text-amber-700' : ($izin->status_approval === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">{{ ucfirst($izin->status_approval) }}</span></td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($izin->status_approval === 'pending')
                                        <form action="{{ route('admin.absensi.approve', $izin) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini?')">@csrf<button class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-600 hover:bg-emerald-100"><i data-lucide="check" class="h-4 w-4"></i> Setujui</button></form>
                                        <form action="{{ route('admin.absensi.reject', $izin) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">@csrf<button class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-100"><i data-lucide="x" class="h-4 w-4"></i> Tolak</button></form>
                                    @else<span class="text-xs text-slate-400 mr-2">{{ $izin->approver?->nama ?? '-' }}</span>@endif
                                    <form action="{{ route('admin.absensi.izin.destroy', $izin) }}" method="POST" onsubmit="return confirm('Hapus data izin/sakit ini?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium text-slate-500 hover:bg-slate-100"><i data-lucide="trash-2" class="h-4 w-4"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty<tr><td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada pengajuan.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        @if ($izinSakits->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $izinSakits->appends(request()->query())->links() }}</div>@endif
    </div>
@endsection
