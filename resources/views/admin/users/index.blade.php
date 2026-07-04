@extends('admin.layout')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy">Kelola Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar semua pengguna terdaftar</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-blue px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98]">
            <i data-lucide="user-plus" class="h-4 w-4"></i>
            Tambah Pengguna
        </a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NISP</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $item)
                        @php
                            $roleColors = [
                                'admin' => 'bg-indigo-100 text-indigo-700',
                                'karyawan' => 'bg-emerald-100 text-emerald-700',
                                'pkl' => 'bg-amber-100 text-amber-700',
                                'pembimbing' => 'bg-purple-100 text-purple-700',
                            ];
                            $roleLabel = [
                                'admin' => 'Admin',
                                'karyawan' => 'Karyawan',
                                'pkl' => 'PKL',
                                'pembimbing' => 'Pembimbing',
                            ];
                        @endphp
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 overflow-hidden rounded-full bg-slate-200">
                                        @if ($item->foto_profile)
                                            <img src="{{ asset('storage/' . $item->foto_profile) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs font-medium text-slate-500">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $item->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $item->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $roleColors[$item->role] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $roleLabel[$item->role] ?? $item->role }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $item->nisp ?? '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $item) }}"
                                       class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-primary-50 hover:text-brand-blue"
                                       title="Edit">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>
                                    <form action="{{ route('admin.users.reset-password', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin mereset password pengguna ini ke: password123?')">
                                        @csrf
                                        <button type="submit"
                                                class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-amber-50 hover:text-amber-600"
                                                title="Reset Password">
                                            <i data-lucide="key-round" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-red-50 hover:text-red-600"
                                                title="Hapus">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($users as $item)
                @php
                    $roleColors = [
                        'admin' => 'bg-indigo-100 text-indigo-700',
                        'karyawan' => 'bg-emerald-100 text-emerald-700',
                        'pkl' => 'bg-amber-100 text-amber-700',
                        'pembimbing' => 'bg-purple-100 text-purple-700',
                    ];
                    $roleLabel = [
                        'admin' => 'Admin',
                        'karyawan' => 'Karyawan',
                        'pkl' => 'PKL',
                        'pembimbing' => 'Pembimbing',
                    ];
                @endphp
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 overflow-hidden rounded-full bg-slate-200 shrink-0">
                                @if ($item->foto_profile)
                                    <img src="{{ asset('storage/' . $item->foto_profile) }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-medium text-slate-500">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->nama }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $item->email }}</p>
                            </div>
                        </div>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $roleColors[$item->role] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ $roleLabel[$item->role] ?? $item->role }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                        <p class="text-xs text-slate-400">NISP: <span class="font-medium text-slate-600">{{ $item->nisp ?? '-' }}</span></p>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $item) }}"
                               class="rounded-lg p-2 text-slate-500 hover:bg-primary-50 hover:text-brand-blue"
                               title="Edit">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </a>
                            <form action="{{ route('admin.users.reset-password', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin mereset password pengguna ini ke: password123?')">
                                @csrf
                                <button type="submit"
                                        class="rounded-lg p-2 text-slate-500 hover:bg-amber-50 hover:text-amber-600"
                                        title="Reset Password">
                                    <i data-lucide="key-round" class="h-4 w-4"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg p-2 text-slate-500 hover:bg-red-50 hover:text-red-600"
                                        title="Hapus">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-sm text-slate-400">Belum ada pengguna terdaftar.</div>
            @endforelse
        </div>

        @if ($users->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
