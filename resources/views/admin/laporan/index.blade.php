@extends('admin.layout')

@section('title', 'Laporan PKL')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Laporan Kegiatan PKL</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola dan validasi laporan kegiatan harian PKL</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
            <i data-lucide="file-text" class="h-6 w-6 text-brand-blue"></i>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-medium text-slate-400">Total</p>
            <p class="mt-1 text-2xl font-bold text-navy">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
            <p class="text-xs font-medium text-amber-600">Menunggu</p>
            <p class="mt-1 text-2xl font-bold text-amber-700">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
            <p class="text-xs font-medium text-emerald-600">Divalidasi</p>
            <p class="mt-1 text-2xl font-bold text-emerald-700">{{ $stats['validated'] }}</p>
        </div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="text-xs font-medium text-red-600">Ditolak</p>
            <p class="mt-1 text-2xl font-bold text-red-700">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="p-4">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-medium text-slate-500">Cari Nama/NISP</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none"
                        placeholder="Cari PKL...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Status</label>
                    <select name="status" class="mt-1 block rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>Divalidasi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="mt-1 block rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex items-center gap-1.5 rounded-lg bg-brand-blue px-4 py-2 text-sm font-medium text-white hover:bg-deep-blue">
                        <i data-lucide="filter" class="h-4 w-4"></i> Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">PKL</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Keterangan</th>
                        <th class="px-6 py-3 font-medium">Foto</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($laporans as $laporan)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-medium text-slate-600">
                                        {{ strtoupper(substr($laporan->user->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700">{{ $laporan->user->nama }}</p>
                                        <p class="text-xs text-slate-400">{{ $laporan->user->nisp ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $laporan->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <p class="text-slate-600 line-clamp-2 max-w-xs">{{ $laporan->keterangan }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($laporan->foto)
                                    <div class="flex gap-1">
                                        @foreach (array_slice($laporan->foto, 0, 2) as $foto)
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="h-10 w-10 rounded-lg object-cover border border-slate-200">
                                        @endforeach
                                        @if (count($laporan->foto) > 2)
                                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">+{{ count($laporan->foto) - 2 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($laporan->status === 'pending')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                        <i data-lucide="clock" class="h-3 w-3"></i> Menunggu
                                    </span>
                                @elseif ($laporan->status === 'validated')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i> Divalidasi
                                    </span>
                                @elseif ($laporan->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                        <i data-lucide="x-circle" class="h-3 w-3"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.laporan.show', $laporan) }}"
                                       class="rounded-lg px-3 py-1.5 text-xs font-medium text-brand-blue hover:bg-primary-50">
                                        Detail
                                    </a>
                                    @if ($laporan->status === 'pending')
                                        <form action="{{ route('admin.laporan.validate', $laporan) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="validated">
                                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">
                                                Validasi
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($laporans as $laporan)
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-xs font-medium text-slate-600 shrink-0">
                                {{ strtoupper(substr($laporan->user->nama, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $laporan->user->nama }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $laporan->tanggal->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div>
                            @if ($laporan->status === 'pending')
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                    <i data-lucide="clock" class="h-3 w-3"></i> Menunggu
                                </span>
                            @elseif ($laporan->status === 'validated')
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                    <i data-lucide="check-circle" class="h-3 w-3"></i> Divalidasi
                                </span>
                            @elseif ($laporan->status === 'rejected')
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">
                                    <i data-lucide="x-circle" class="h-3 w-3"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs text-slate-400">Keterangan:</p>
                        <p class="text-xs text-slate-700 line-clamp-3 bg-slate-50 p-2.5 rounded-xl border border-slate-100">{{ $laporan->keterangan }}</p>
                    </div>
                    @if ($laporan->foto)
                        <div class="flex items-center gap-2 pt-1">
                            <span class="text-xs text-slate-400 mr-1">Foto Kegiatan:</span>
                            <div class="flex gap-1.5">
                                @foreach (array_slice($laporan->foto, 0, 3) as $foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="h-10 w-10 rounded-lg object-cover border border-slate-200">
                                @endforeach
                                @if (count($laporan->foto) > 3)
                                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-400">+{{ count($laporan->foto) - 3 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center justify-between pt-3 border-t border-slate-50">
                        <p class="text-xs text-slate-400">NISP: <span class="font-medium text-slate-600">{{ $laporan->user->nisp ?? '-' }}</span></p>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.laporan.show', $laporan) }}"
                               class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                Detail
                            </a>
                            @if ($laporan->status === 'pending')
                                <form action="{{ route('admin.laporan.validate', $laporan) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="validated">
                                    <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 shadow-sm">
                                        Validasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-sm text-slate-400">Tidak ada laporan.</div>
            @endforelse
        </div>

        @if ($laporans->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
