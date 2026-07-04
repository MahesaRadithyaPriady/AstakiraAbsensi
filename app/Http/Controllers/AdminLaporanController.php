<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'validator']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->get('tanggal'));
        }

        $laporans = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Laporan::count(),
            'pending' => Laporan::where('status', 'pending')->count(),
            'validated' => Laporan::where('status', 'validated')->count(),
            'rejected' => Laporan::where('status', 'rejected')->count(),
        ];

        return view('admin.laporan.index', compact('laporans', 'stats'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load(['user', 'validator']);
        return view('admin.laporan.show', compact('laporan'));
    }

    public function validate(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status' => 'required|in:validated,rejected',
            'catatan_validasi' => 'nullable|string|max:500',
        ]);

        $laporan->update([
            'status' => $validated['status'],
            'catatan_validasi' => $validated['catatan_validasi'] ?? null,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        $label = $validated['status'] === 'validated' ? 'divalidasi' : 'ditolak';

        return back()->with('success', "Laporan berhasil {$label}.");
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->foto) {
            foreach ($laporan->foto as $path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
        }

        $laporan->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
