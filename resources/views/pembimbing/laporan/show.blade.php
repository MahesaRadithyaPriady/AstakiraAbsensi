@extends('pembimbing.layout')

@section('title', 'Detail Laporan')

@section('content')
<div class="space-y-6">
    <a href="{{ route('pembimbing.laporan.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-blue">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Daftar Laporan
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
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

        <div class="space-y-6 p-6">
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

            <div>
                <h3 class="text-sm font-semibold text-slate-700">Keterangan Kegiatan</h3>
                <div class="mt-2 rounded-xl bg-slate-50 p-4">
                    <p class="text-sm leading-relaxed text-slate-600 whitespace-pre-wrap">{{ $laporan->keterangan }}</p>
                </div>
            </div>

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

            @if ($laporan->catatan_validasi)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700">Catatan Validasi</h3>
                    <div class="mt-2 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-600">{{ $laporan->catatan_validasi }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
