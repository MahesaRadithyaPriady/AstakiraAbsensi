<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PklLaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $laporanToday = Laporan::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        $riwayat = Laporan::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $pklActive = $user->isPklActive();

        return view('pkl.laporan', compact('laporanToday', 'riwayat', 'pklActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|min:10',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'keterangan.required' => 'Keterangan kegiatan wajib diisi.',
            'keterangan.min' => 'Keterangan minimal 10 karakter.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.mimes' => 'Format foto: jpeg, png, jpg.',
            'foto.*.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $user = Auth::user();
        $today = now()->toDateString();

        if (!$user->isPklActive()) {
            return back()->with('error', 'Masa PKL Anda belum dimulai atau sudah berakhir. Laporan tidak dapat dikirim di luar masa PKL.');
        }

        $existing = Laporan::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengirim laporan hari ini.');
        }

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('laporan', 'public');
                $fotoPaths[] = $path;
            }
        }

        Laporan::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'keterangan' => $validated['keterangan'],
            'foto' => $fotoPaths ?: null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Laporan kegiatan berhasil dikirim. Menunggu validasi pembimbing.');
    }
}
