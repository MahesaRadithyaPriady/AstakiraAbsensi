@extends('pkl.layout')

@section('title', 'SOP PKL')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">SOP PKL</h1>
            <p class="mt-1 text-sm text-slate-500">Standar Operasional Prosedur untuk PKL</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
            <i data-lucide="clipboard-list" class="h-6 w-6 text-brand-blue"></i>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    @if ($sops->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                <i data-lucide="clipboard-list" class="h-7 w-7 text-slate-400"></i>
            </div>
            <h3 class="mt-4 text-sm font-semibold text-slate-700">Belum ada SOP</h3>
            <p class="mt-1 text-sm text-slate-400">SOP akan muncul di sini ketika admin menambahkannya.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($sops as $sop)
                <a href="{{ route('pkl.sop.show', $sop) }}"
                   class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-brand-blue hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100">
                            <i data-lucide="file-text" class="h-5 w-5 text-brand-blue"></i>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-brand-blue">
                            {{ $sop->kategori }}
                        </span>
                    </div>
                    <h3 class="mt-3 text-sm font-semibold text-slate-800 group-hover:text-brand-blue">{{ $sop->judul }}</h3>
                    @if ($sop->deskripsi)
                        <p class="mt-1 text-xs text-slate-400 line-clamp-2">{{ $sop->deskripsi }}</p>
                    @endif
                    @if ($sop->file_path)
                        <div class="mt-3 flex items-center gap-1.5 text-xs font-medium text-brand-blue">
                            <i data-lucide="paperclip" class="h-3.5 w-3.5"></i>
                            File tersedia
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
