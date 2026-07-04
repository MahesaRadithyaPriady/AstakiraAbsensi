@extends('pkl.layout')

@section('title', 'Dashboard PKL')

@section('content')
    {{-- Welcome banner --}}
    <div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#0a1628] via-[#0d2b55] to-[#0b5ed7] p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Halo, {{ $user->nama }}!</h2>
                <p class="mt-1 text-sm text-slate-300">Selamat datang di dashboard PKL</p>
            </div>
            <div class="hidden h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur sm:flex">
                <i data-lucide="graduation-cap" class="h-8 w-8 text-white"></i>
            </div>
        </div>
    </div>

    {{-- Info cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        {{-- NISP --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50">
                    <i data-lucide="badge-info" class="h-5 w-5 text-brand-blue"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400">NISP</p>
                    <p class="text-sm font-bold text-navy">{{ $user->nisp ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Role --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                    <i data-lucide="user" class="h-5 w-5 text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400">Status</p>
                    <p class="text-sm font-bold text-navy">PKL</p>
                </div>
            </div>
        </div>

        {{-- Tanggal Lahir --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100">
                    <i data-lucide="calendar" class="h-5 w-5 text-amber-600"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400">Tanggal Lahir</p>
                    <p class="text-sm font-bold text-navy">{{ $user->tanggal_lahir?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Pembimbing info --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-navy">Pembimbing Saya</h2>
            <i data-lucide="user-check" class="h-5 w-5 text-slate-400"></i>
        </div>

        @if ($user->pembimbing->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach ($user->pembimbing as $pembimbing)
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="h-12 w-12 overflow-hidden rounded-full bg-slate-200">
                            @if ($pembimbing->foto_profile)
                                <img src="{{ asset('storage/' . $pembimbing->foto_profile) }}" alt="{{ $pembimbing->nama }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                                    {{ strtoupper(substr($pembimbing->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-700">{{ $pembimbing->nama }}</p>
                            <p class="text-xs text-slate-400">{{ $pembimbing->email }}</p>
                        </div>
                        <span class="rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-700">Pembimbing</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center px-6 py-12 text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                    <i data-lucide="alert-triangle" class="h-8 w-8 text-amber-600"></i>
                </div>
                <h3 class="text-base font-semibold text-navy">Belum Memiliki Pembimbing</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-400">
                    Anda belum memiliki pembimbing yang ditugaskan. Silakan hubungi administrator untuk mendapatkan pembimbing.
                </p>
            </div>
        @endif
    </div>
@endsection
