<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nisp' => ['nullable', 'string', 'max:255'],
            'foto_profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role' => ['required', 'in:admin,karyawan,pkl,pembimbing'],
        ];

        $validated = $request->validate($rules);

        if ($request->input('role') === 'pkl') {
            $validated['nisp'] = $this->generateNisp();
        } else {
            $validated['nisp'] = null;
        }

        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('foto-profile', 'public');
            $validated['foto_profile'] = $path;
        }

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nisp' => ['nullable', 'string', 'max:255'],
            'foto_profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role' => ['required', 'in:admin,karyawan,pkl,pembimbing'],
        ];

        $validated = $request->validate($rules);

        if ($request->input('role') === 'pkl') {
            if ($user->nisp) {
                $validated['nisp'] = $user->nisp;
            } else {
                $validated['nisp'] = $this->generateNisp();
            }
        } else {
            $validated['nisp'] = null;
        }

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }
            $path = $request->file('foto_profile')->store('foto-profile', 'public');
            $validated['foto_profile'] = $path;
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->foto_profile) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function generateNisp(): string
    {
        do {
            $number = random_int(1000, 9999);
            $nisp = 'AST-' . $number;
        } while (User::where('nisp', $nisp)->exists());

        return $nisp;
    }
}
