@extends('pembimbing.layout')

@section('title', $sop->judul)

@section('content')
<div class="space-y-6">
    <a href="{{ route('pembimbing.sop.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-blue">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Daftar SOP
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <span class="inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-brand-blue">
                        {{ $sop->kategori }}
                    </span>
                    <h2 class="mt-2 text-lg font-semibold text-navy">{{ $sop->judul }}</h2>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary-100">
                    <i data-lucide="file-text" class="h-6 w-6 text-brand-blue"></i>
                </div>
            </div>
        </div>

        <div class="space-y-6 p-6">
            @if ($sop->deskripsi)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700">Deskripsi</h3>
                    <div class="mt-2 rounded-xl bg-slate-50 p-4">
                        <p class="text-sm leading-relaxed text-slate-600 whitespace-pre-wrap">{{ $sop->deskripsi }}</p>
                    </div>
                </div>
            @endif

            @if ($sop->file_path)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700">File SOP</h3>
                    <div class="mt-2 flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-100">
                            <i data-lucide="file-text" class="h-5 w-5 text-brand-blue"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ basename($sop->file_path) }}</p>
                            <p class="text-xs text-slate-400">Klik untuk membuka file</p>
                        </div>
                        <a href="{{ asset('storage/' . $sop->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-deep-blue">
                            <i data-lucide="download" class="h-4 w-4"></i>
                            Buka File
                        </a>
                    </div>
                </div>
            @endif

            <div class="border-t border-slate-100 pt-4">
                <p class="text-xs text-slate-400">Dibuat pada {{ $sop->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
