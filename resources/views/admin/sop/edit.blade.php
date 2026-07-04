@extends('admin.layout')

@section('title', 'Edit SOP')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.sop.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-blue">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Daftar SOP
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Edit SOP</h2>
            <p class="mt-0.5 text-sm text-slate-400">Perbarui data Standar Operasional Prosedur</p>
        </div>

        <form action="{{ route('admin.sop.update', $sop) }}" method="POST" enctype="multipart/form-data" class="space-y-5 p-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700">Judul SOP <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $sop->judul) }}"
                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 transition-colors placeholder-slate-400 focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                    placeholder="Contoh: Prosedur Absensi PKL">
                @error('judul')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="kategori" value="{{ old('kategori', $sop->kategori) }}"
                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 transition-colors placeholder-slate-400 focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                    placeholder="Contoh: absensi, laporan, keamanan">
                @error('kategori')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 transition-colors placeholder-slate-400 focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                    placeholder="Penjelasan singkat tentang SOP ini...">{{ old('deskripsi', $sop->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">File SOP (PDF/DOC/DOCX, maks 5MB)</label>
                @if ($sop->file_path)
                    <div class="mt-1.5 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5">
                        <i data-lucide="file-text" class="h-4 w-4 text-brand-blue"></i>
                        <a href="{{ asset('storage/' . $sop->file_path) }}" target="_blank" class="text-sm text-brand-blue hover:underline">File saat ini</a>
                        <span class="text-xs text-slate-400">— kosongkan jika tidak ingin ganti</span>
                    </div>
                @endif
                <input type="file" name="file" accept=".pdf,.doc,.docx"
                    class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-blue hover:file:bg-primary-100 focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none">
                @error('file')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $sop->urutan) }}" min="0"
                        class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 transition-colors focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none">
                    <p class="mt-1 text-xs text-slate-400">SOP dengan urutan lebih kecil tampil lebih dulu.</p>
                    @error('urutan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Status</label>
                    <label class="mt-1.5 flex cursor-pointer items-center gap-3 rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sop->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <span class="text-sm text-slate-700">Aktif (tampil untuk PKL)</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.sop.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
