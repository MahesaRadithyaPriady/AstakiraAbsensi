@extends('admin.layout')

@section('title', 'SOP PKL')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">SOP PKL</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola Standar Operasional Prosedur untuk PKL</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.sop.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah SOP
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-400">
                    <tr>
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Judul</th>
                        <th class="px-6 py-3 font-medium">Kategori</th>
                        <th class="px-6 py-3 font-medium">File</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($sops as $sop)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-400">{{ $sop->urutan }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-700">{{ $sop->judul }}</p>
                                @if ($sop->deskripsi)
                                    <p class="text-xs text-slate-400 line-clamp-1 max-w-xs">{{ $sop->deskripsi }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-brand-blue">
                                    {{ $sop->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($sop->file_path)
                                    <a href="{{ asset('storage/' . $sop->file_path) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-brand-blue hover:underline">
                                        <i data-lucide="file-text" class="h-3.5 w-3.5"></i>
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($sop->is_active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-500">
                                        <i data-lucide="pause" class="h-3 w-3"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.sop.edit', $sop) }}"
                                       class="rounded-lg px-3 py-1.5 text-xs font-medium text-brand-blue hover:bg-primary-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.sop.destroy', $sop) }}" method="POST"
                                          onsubmit="return confirm('Hapus SOP ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada SOP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($sops as $sop)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800">{{ $sop->judul }}</p>
                            @if ($sop->deskripsi)
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $sop->deskripsi }}</p>
                            @endif
                        </div>
                        <span class="shrink-0 inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-brand-blue">
                            {{ $sop->kategori }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        <div class="flex items-center gap-2">
                            @if ($sop->is_active)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-500">Nonaktif</span>
                            @endif
                            @if ($sop->file_path)
                                <a href="{{ asset('storage/' . $sop->file_path) }}" target="_blank"
                                   class="text-xs font-medium text-brand-blue hover:underline">Lihat File</a>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.sop.edit', $sop) }}"
                               class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-brand-blue hover:bg-slate-200">Edit</a>
                            <form action="{{ route('admin.sop.destroy', $sop) }}" method="POST"
                                  onsubmit="return confirm('Hapus SOP ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-sm text-slate-400">Belum ada SOP.</div>
            @endforelse
        </div>

        @if ($sops->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $sops->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
