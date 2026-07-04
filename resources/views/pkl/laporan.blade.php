@extends('pkl.layout')

@section('title', 'Laporan Kegiatan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Laporan Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">Laporan kegiatan PKL harian</p>
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

    @if (session('error'))
        <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
            <i data-lucide="x-circle" class="h-5 w-5 text-red-600"></i>
            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
            <i data-lucide="alert-circle" class="h-5 w-5 text-red-600"></i>
            <div class="text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Form or today's report status --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Laporan Hari Ini</h2>
            <p class="text-sm text-slate-400">{{ now()->format('l, d F Y') }}</p>
        </div>

        <div class="p-6">
            @if ($laporanToday)
                {{-- Already submitted --}}
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    @if ($laporanToday->status === 'pending')
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                            <i data-lucide="clock" class="h-8 w-8 text-amber-600"></i>
                        </div>
                        <h3 class="text-base font-semibold text-navy">Menunggu Validasi</h3>
                        <p class="mt-1 text-sm text-slate-400">Laporan Anda sedang menunggu validasi dari pembimbing.</p>
                    @elseif ($laporanToday->status === 'validated')
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                            <i data-lucide="check-circle" class="h-8 w-8 text-emerald-600"></i>
                        </div>
                        <h3 class="text-base font-semibold text-navy">Laporan Divalidasi</h3>
                        <p class="mt-1 text-sm text-slate-400">Laporan Anda telah divalidasi oleh pembimbing.</p>
                        @if ($laporanToday->validator)
                            <p class="mt-1 text-xs text-slate-400">Divalidasi oleh: {{ $laporanToday->validator->nama }}</p>
                        @endif
                    @elseif ($laporanToday->status === 'rejected')
                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                            <i data-lucide="x-circle" class="h-8 w-8 text-red-600"></i>
                        </div>
                        <h3 class="text-base font-semibold text-navy">Laporan Ditolak</h3>
                        @if ($laporanToday->catatan_validasi)
                            <p class="mt-1 text-sm text-red-500">{{ $laporanToday->catatan_validasi }}</p>
                        @endif
                    @endif

                    <div class="mt-4 w-full max-w-md rounded-xl bg-slate-50 p-4 text-left">
                        <p class="text-xs font-medium text-slate-400">Keterangan Kegiatan:</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $laporanToday->keterangan }}</p>
                        @if ($laporanToday->foto)
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($laporanToday->foto as $foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto laporan" class="h-20 w-20 rounded-lg object-cover border border-slate-200">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- Form --}}
                <form action="{{ route('pkl.laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-4">
                        {{-- Keterangan --}}
                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-slate-700">Keterangan Kegiatan <span class="text-red-500">*</span></label>
                            <p class="mb-2 text-xs text-slate-400">Jelaskan kegiatan yang Anda lakukan hari ini (minimal 10 karakter).</p>
                            <textarea id="keterangan" name="keterangan" rows="5" required
                                class="mt-1 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-brand-blue focus:ring-2 focus:ring-primary-100 focus:outline-none"
                                placeholder="Hari ini saya mengerjakan...">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Foto --}}
                        <div>
                            <label for="foto" class="block text-sm font-medium text-slate-700">Foto Kegiatan <span class="text-slate-400 text-xs">(opsional, maks 3 foto)</span></label>
                            <p class="mb-2 text-xs text-slate-400">Upload foto bukti kegiatan. Format: jpeg, png, jpg. Maks 2MB per foto.</p>
                            <input id="foto" name="foto[]" type="file" accept="image/jpeg,image/png,image/jpg" multiple
                                class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-brand-blue hover:file:bg-primary-100">
                            <div id="foto-preview" class="mt-3 flex flex-wrap gap-2"></div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex justify-end">
                            <button type="submit"
                                class="flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                                <i data-lucide="send" class="h-4 w-4"></i>
                                Kirim Laporan
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    {{-- Riwayat Laporan --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Riwayat Laporan</h2>
        </div>
        <div class="p-6">
            @if ($riwayat->isEmpty())
                <div class="py-8 text-center">
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                        <i data-lucide="inbox" class="h-6 w-6 text-slate-400"></i>
                    </div>
                    <p class="text-sm text-slate-400">Belum ada laporan.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($riwayat as $laporan)
                        <div class="rounded-xl border border-slate-200 p-4 transition hover:border-slate-300">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-slate-700">{{ $laporan->tanggal->format('d M Y') }}</span>
                                        @if ($laporan->status === 'pending')
                                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">Menunggu</span>
                                        @elseif ($laporan->status === 'validated')
                                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Divalidasi</span>
                                        @elseif ($laporan->status === 'rejected')
                                            <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Ditolak</span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $laporan->keterangan }}</p>
                                    @if ($laporan->foto)
                                        <div class="mt-2 flex flex-wrap gap-1.5">
                                            @foreach (array_slice($laporan->foto, 0, 3) as $foto)
                                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="h-14 w-14 rounded-lg object-cover border border-slate-200">
                                            @endforeach
                                            @if (count($laporan->foto) > 3)
                                                <div class="flex h-14 w-14 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-xs text-slate-400">
                                                    +{{ count($laporan->foto) - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($laporan->catatan_validasi)
                                        <p class="mt-2 text-xs text-slate-400">Catatan: {{ $laporan->catatan_validasi }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    const fotoInput = document.getElementById('foto');
    const fotoPreview = document.getElementById('foto-preview');

    if (fotoInput) {
        fotoInput.addEventListener('change', (e) => {
            fotoPreview.innerHTML = '';
            const files = Array.from(e.target.files).slice(0, 3);
            if (files.length > 3) {
                alert('Maksimal 3 foto.');
                fotoInput.value = '';
                return;
            }
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'h-20 w-20 rounded-lg object-cover border border-slate-200';
                    fotoPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    }
</script>
@endpush
@endsection
