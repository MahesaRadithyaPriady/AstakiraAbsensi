<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'foto_profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }
            $path = $request->file('foto_profile')->store('foto-profile', 'public');
            $validated['foto_profile'] = $path;
        }

        $user->update($validated);

        return redirect()->route('settings.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!password_verify($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()->route('settings.index')->with('success', 'Password berhasil diubah.');
    }
}
