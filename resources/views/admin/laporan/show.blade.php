@extends('admin.layout')

@section('title', 'Detail Laporan')

@section('content')
<div class="space-y-6">
    {{-- Back link --}}
    <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-blue">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Daftar Laporan
    </a>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Detail --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        {{-- Header --}}
        <div class="border-b border-slate-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-sm font-medium text-slate-600">
                        {{ strtoupper(substr($laporan->user->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-navy">{{ $laporan->user->nama }}</h2>
                        <p class="text-sm text-slate-400">{{ $laporan->user->nisp ?? 'Tanpa NISP' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-600">{{ $laporan->tanggal->format('d M Y') }}</p>
                    <p class="text-xs text-slate-400">{{ $laporan->tanggal->format('l') }}</p>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="space-y-6 p-6">
            {{-- Status --}}
            <div class="flex items-center gap-2">
                @if ($laporan->status === 'pending')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-700">
                        <i data-lucide="clock" class="h-4 w-4"></i> Menunggu Validasi
                    </span>
                @elseif ($laporan->status === 'validated')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700">
                        <i data-lucide="check-circle" class="h-4 w-4"></i> Divalidasi
                    </span>
                    @if ($laporan->validator)
                        <span class="text-sm text-slate-400">oleh {{ $laporan->validator->nama }} pada {{ $laporan->validated_at->format('d M Y H:i') }}</span>
                    @endif
                @elseif ($laporan->status === 'rejected')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-700">
                        <i data-lucide="x-circle" class="h-4 w-4"></i> Ditolak
                    </span>
                    @if ($laporan->validator)
                        <span class="text-sm text-slate-400">oleh {{ $laporan->validator->nama }} pada {{ $laporan->validated_at->format('d M Y H:i') }}</span>
                    @endif
                @endif
            </div>

            {{-- Keterangan --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-700">Keterangan Kegiatan</h3>
                <div class="mt-2 rounded-xl bg-slate-50 p-4">
                    <p class="text-sm leading-relaxed text-slate-600 whitespace-pre-wrap">{{ $laporan->keterangan }}</p>
                </div>
            </div>

            {{-- Foto --}}
            @if ($laporan->foto)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700">Foto Kegiatan</h3>
                    <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach ($laporan->foto as $foto)
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto kegiatan" class="aspect-square w-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Catatan validasi --}}
            @if ($laporan->catatan_validasi)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700">Catatan Validasi</h3>
                    <div class="mt-2 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-600">{{ $laporan->catatan_validasi }}</p>
                    </div>
                </div>
            @endif

            {{-- Validation actions --}}
            @if ($laporan->status === 'pending')
                <div class="border-t border-slate-100 pt-4">
                    <h3 class="text-sm font-semibold text-slate-700">Validasi Laporan</h3>
                    <p class="mt-1 text-xs text-slate-400">Tandai laporan ini sebagai valid atau tolak dengan catatan.</p>
                    <div class="mt-3 flex flex-wrap gap-3">
                        <form action="{{ route('admin.laporan.validate', $laporan) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="validated">
                            <button type="submit" class="flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                                <i data-lucide="check" class="h-4 w-4"></i>
                                Setujui / Validasi
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('reject-form').classList.toggle('hidden')"
                            class="flex items-center gap-2 rounded-xl border border-red-300 px-5 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50">
                            <i data-lucide="x" class="h-4 w-4"></i>
                            Tolak
                        </button>
                    </div>
                    <form id="reject-form" action="{{ route('admin.laporan.validate', $laporan) }}" method="POST" class="mt-3 hidden">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <div>
                            <label class="block text-xs font-medium text-slate-500">Catatan Penolakan</label>
                            <textarea name="catatan_validasi" rows="3"
                                class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:outline-none"
                                placeholder="Alasan penolakan..."></textarea>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                                Konfirmasi Tolak
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Delete --}}
            <div class="border-t border-slate-100 pt-4">
                <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 text-sm font-medium text-red-500 hover:text-red-700">
                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                        Hapus Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
