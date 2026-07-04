@extends('admin.layout')

@section('title', 'Pembimbing')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-navy">Pembimbing PKL</h1>
        <p class="mt-1 text-sm text-slate-500">Daftar pembimbing dan anak PKL yang dibimbing</p>
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="check-circle" class="h-4 w-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Pembimbing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500">Jumlah Anak PKL</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pembimbings as $pembimbing)
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 overflow-hidden rounded-full bg-slate-200">
                                        @if ($pembimbing->foto_profile)
                                            <img src="{{ asset('storage/' . $pembimbing->foto_profile) }}" alt="{{ $pembimbing->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                                                {{ strtoupper(substr($pembimbing->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $pembimbing->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $pembimbing->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-700">
                                    {{ $pembimbing->anak_pkl_count }} PKL
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="{{ route('admin.pembimbing.show', $pembimbing) }}"
                                   class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-blue transition-colors hover:bg-primary-50">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                    Kelola Anak PKL
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada pembimbing terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($pembimbings as $pembimbing)
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 overflow-hidden rounded-full bg-slate-200 shrink-0">
                                @if ($pembimbing->foto_profile)
                                    <img src="{{ asset('storage/' . $pembimbing->foto_profile) }}" alt="{{ $pembimbing->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                                        {{ strtoupper(substr($pembimbing->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $pembimbing->nama }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $pembimbing->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-700">
                            {{ $pembimbing->anak_pkl_count }} PKL
                        </span>
                        <a href="{{ route('admin.pembimbing.show', $pembimbing) }}"
                           class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-brand-blue hover:bg-primary-50">
                            <i data-lucide="users" class="h-3.5 w-3.5"></i>
                            Kelola Anak PKL
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-sm text-slate-400">Belum ada pembimbing terdaftar.</div>
            @endforelse
        </div>

        @if ($pembimbings->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $pembimbings->links() }}
            </div>
        @endif
    </div>
@endsection
