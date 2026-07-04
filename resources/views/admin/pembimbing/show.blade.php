@extends('admin.layout')

@section('title', 'Kelola Anak PKL')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pembimbing.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition-colors hover:text-blue-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali
        </a>
    </div>

    {{-- Pembimbing info --}}
    <div class="mb-6 flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="h-14 w-14 overflow-hidden rounded-full bg-slate-200">
            @if ($pembimbing->foto_profile)
                <img src="{{ asset('storage/' . $pembimbing->foto_profile) }}" alt="{{ $pembimbing->nama }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-lg font-medium text-slate-500">
                    {{ strtoupper(substr($pembimbing->nama, 0, 1)) }}
                </div>
            @endif
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $pembimbing->nama }}</h1>
            <p class="text-sm text-slate-500">{{ $pembimbing->email }}</p>
        </div>
        <span class="ml-auto rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-700">
            {{ $pembimbing->anakPkl->count() }} Anak PKL
        </span>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="check-circle" class="h-4 w-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Assigned PKL --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-800">Anak PKL Saat Ini</h2>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">{{ $pembimbing->anakPkl->count() }}</span>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($pembimbing->anakPkl as $pkl)
                    <div class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200">
                                @if ($pkl->foto_profile)
                                    <img src="{{ asset('storage/' . $pkl->foto_profile) }}" alt="{{ $pkl->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                                        {{ strtoupper(substr($pkl->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $pkl->nama }}</p>
                                <p class="text-xs text-slate-400">{{ $pkl->nisp ?? 'Tanpa NISP' }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.pembimbing.unassign', [$pembimbing, $pkl]) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin melepas anak PKL ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-red-50 hover:text-red-600"
                                    title="Lepas">
                                <i data-lucide="x" class="h-4 w-4"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-slate-400">Belum ada anak PKL.</div>
                @endforelse
            </div>
        </div>

        {{-- Available PKL to assign --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-800">Tambah Anak PKL</h2>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">{{ $availablePkls->count() }} tersedia</span>
            </div>

            @if ($availablePkls->isNotEmpty())
                <form action="{{ route('admin.pembimbing.assign', $pembimbing) }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-2">
                        @foreach ($availablePkls as $pkl)
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition-colors hover:bg-slate-50">
                                <input type="checkbox" name="pkl_ids[]" value="{{ $pkl->id }}"
                                       class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                    @if ($pkl->foto_profile)
                                        <img src="{{ asset('storage/' . $pkl->foto_profile) }}" alt="{{ $pkl->nama }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">
                                            {{ strtoupper(substr($pkl->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-700">{{ $pkl->nama }}</p>
                                    <p class="truncate text-xs text-slate-400">{{ $pkl->nisp ?? 'Tanpa NISP' }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit"
                            class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:from-blue-700 hover:to-blue-800 active:scale-[0.98]">
                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                        Tambahkan ke Pembimbing
                    </button>
                </form>
            @else
                <div class="px-6 py-12 text-center text-sm text-slate-400">
                    Tidak ada PKL yang belum dibimbing.
                </div>
            @endif
        </div>
    </div>
@endsection
