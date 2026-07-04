@extends('admin.layout')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition-colors hover:text-brand-blue">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-navy">Tambah Pengguna</h1>
        <p class="mt-1 text-sm text-slate-500">Daftarkan akun pengguna baru</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
            <div class="flex items-center gap-2 text-sm text-red-700">
                <i data-lucide="alert-circle" class="h-4 w-4 shrink-0"></i>
                <span>Periksa kembali data yang dimasukkan.</span>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            {{-- Nama --}}
            <div>
                <label for="nama" class="mb-1.5 block text-sm font-medium text-slate-700">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('nama') border-red-400 @enderror"
                       value="{{ old('nama') }}" required>
                @error('nama') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('email') border-red-400 @enderror"
                       value="{{ old('email') }}" required>
                @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('password') border-red-400 @enderror"
                       required>
                @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="mb-1.5 block text-sm font-medium text-slate-700">Role <span class="text-red-500">*</span></label>
                <select id="role" name="role"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('role') border-red-400 @enderror">
                    <option value="">Pilih role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="pkl" {{ old('role') === 'pkl' ? 'selected' : '' }}>PKL</option>
                    <option value="pembimbing" {{ old('role') === 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                </select>
                @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('tanggal_lahir') border-red-400 @enderror"
                       value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- NISP --}}
            <div id="nisp-field">
                <label for="nisp" class="mb-1.5 block text-sm font-medium text-slate-700">NISP</label>
                <input type="text" id="nisp" name="nisp"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('nisp') border-red-400 @enderror"
                       value="{{ old('nisp') }}" placeholder="Hanya untuk role PKL" disabled>
                <p id="nisp-hint" class="mt-1 text-xs text-slate-400">Hanya untuk role PKL, auto-generate.</p>
                @error('nisp') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Masa PKL --}}
            <div id="pkl-period-field" class="hidden">
                <label for="tanggal_mulai_pkl" class="mb-1.5 block text-sm font-medium text-slate-700">Mulai PKL</label>
                <input type="date" id="tanggal_mulai_pkl" name="tanggal_mulai_pkl"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                       value="{{ old('tanggal_mulai_pkl') }}">
            </div>
            <div id="pkl-period-field2" class="hidden">
                <label for="tanggal_selesai_pkl" class="mb-1.5 block text-sm font-medium text-slate-700">Selesai PKL</label>
                <input type="date" id="tanggal_selesai_pkl" name="tanggal_selesai_pkl"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none"
                       value="{{ old('tanggal_selesai_pkl') }}">
            </div>

            {{-- Alamat --}}
            <div class="sm:col-span-2">
                <label for="alamat" class="mb-1.5 block text-sm font-medium text-slate-700">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                          class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-800 placeholder-slate-400 transition-all focus:border-brand-blue focus:bg-white focus:ring-2 focus:ring-primary-100 focus:outline-none @error('alamat') border-red-400 @enderror"
                          placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Foto Profile --}}
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Foto Profile</label>
                <div id="drop-zone" class="relative flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition-all hover:border-primary-400 hover:bg-primary-50/50">
                    <input type="file" id="foto_profile" name="foto_profile" accept="image/*"
                           class="absolute inset-0 h-full w-full cursor-pointer opacity-0 @error('foto_profile') border-red-400 @enderror">
                    <div id="drop-placeholder" class="pointer-events-none">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100">
                            <i data-lucide="upload-cloud" class="h-6 w-6 text-brand-blue"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-600">Drag & drop foto di sini atau <span class="text-brand-blue">klik untuk pilih</span></p>
                        <p class="mt-1 text-xs text-slate-400">Format: JPG, JPEG, PNG, WebP. Maks 2MB.</p>
                    </div>
                    <div id="drop-preview" class="hidden pointer-events-none text-center">
                        <img id="preview-img" src="" alt="Preview" class="mx-auto mb-3 h-32 w-32 rounded-xl object-cover border border-slate-200">
                        <p id="preview-name" class="text-sm font-medium text-slate-600"></p>
                        <p class="mt-1 text-xs text-brand-blue">Klik untuk ganti foto</p>
                    </div>
                </div>
                @error('foto_profile') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
                <i data-lucide="save" class="h-4 w-4"></i>
                Simpan
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50">
                Batal
            </a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const roleSelect = document.getElementById('role');
    const nispInput = document.getElementById('nisp');
    const nispHint = document.getElementById('nisp-hint');
    const pklPeriodField = document.getElementById('pkl-period-field');
    const pklPeriodField2 = document.getElementById('pkl-period-field2');

    function toggleNisp() {
        const isPkl = roleSelect.value === 'pkl';
        if (isPkl) {
            nispInput.disabled = false;
            nispInput.readOnly = true;
            nispInput.value = 'Auto-generate saat simpan';
            nispInput.classList.add('bg-primary-50', 'text-brand-blue', 'font-medium');
            nispHint.textContent = 'NISP akan auto-generate (AST-XXXX) saat simpan.';
            nispHint.classList.remove('text-slate-400');
            nispHint.classList.add('text-amber-600');
            pklPeriodField.classList.remove('hidden');
            pklPeriodField2.classList.remove('hidden');
        } else {
            nispInput.disabled = true;
            nispInput.readOnly = false;
            nispInput.value = '';
            nispInput.classList.remove('bg-primary-50', 'text-brand-blue', 'font-medium');
            nispInput.placeholder = 'Hanya untuk role PKL';
            nispHint.textContent = 'Hanya untuk role PKL, auto-generate.';
            nispHint.classList.add('text-slate-400');
            nispHint.classList.remove('text-amber-600');
            pklPeriodField.classList.add('hidden');
            pklPeriodField2.classList.add('hidden');
        }
    }

    roleSelect.addEventListener('change', toggleNisp);
    toggleNisp();

    // Drag and drop foto profile
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('foto_profile');
    const dropPlaceholder = document.getElementById('drop-placeholder');
    const dropPreview = document.getElementById('drop-preview');
    const previewImg = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');

    function showPreview(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                dropPlaceholder.classList.add('hidden');
                dropPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            showPreview(e.target.files[0]);
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-brand-blue', 'bg-primary-50');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-brand-blue', 'bg-primary-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-brand-blue', 'bg-primary-50');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            showPreview(e.dataTransfer.files[0]);
        }
    });
</script>
@endpush
