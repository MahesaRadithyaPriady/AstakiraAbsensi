@extends(auth()->user()->isAdmin() ? 'admin.layout' : 'pkl.layout')

@section('title', 'Pengaturan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Pengaturan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola profil dan keamanan akun Anda</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
            <i data-lucide="settings" class="h-6 w-6 text-brand-blue"></i>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
            <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
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

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Edit Profile --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">Edit Profil</h2>
                <p class="text-sm text-slate-400">Perbarui data diri Anda</p>
            </div>

            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Foto Profile --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Foto Profile</label>
                        <div class="flex items-center gap-4">
                            <div class="h-20 w-20 overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                @if (auth()->user()->foto_profile)
                                    <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="{{ auth()->user()->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xl font-medium text-slate-400">
                                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" id="foto_profile" name="foto_profile" accept="image/*"
                                       class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-brand-blue hover:file:bg-primary-100">
                                <p class="mt-1 text-xs text-slate-400">Format: JPG, JPEG, PNG, WebP. Maks 2MB.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="mb-1.5 block text-sm font-medium text-slate-700">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               value="{{ old('nama', auth()->user()->nama) }}" required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir?->format('Y-m-d')) }}">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="mb-1.5 block text-sm font-medium text-slate-700">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                            <i data-lucide="save" class="h-4 w-4"></i>
                            Simpan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-base font-semibold text-navy">Ubah Password</h2>
                <p class="text-sm text-slate-400">Pastikan akun Anda aman</p>
            </div>

            <form action="{{ route('settings.password.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="mb-1.5 block text-sm font-medium text-slate-700">Password Saat Ini <span class="text-red-500">*</span></label>
                        <input type="password" id="current_password" name="current_password"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               required>
                        @error('current_password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password Baru <span class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               required>
                        @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                               required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-deep-blue">
                            <i data-lucide="key-round" class="h-4 w-4"></i>
                            Ubah Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
