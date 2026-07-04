<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\IzinSakit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $today = now()->toDateString();
        $selectedDate = $request->input('tanggal', $today);

        $pklUsers = User::where('role', 'pkl')->orderBy('nama')->get();
        $pklIds = $pklUsers->pluck('id');

        $absensisToday = Absensi::whereIn('user_id', $pklIds)
            ->where('tanggal', $selectedDate)
            ->get()
            ->keyBy('user_id');

        $izinSakitsToday = IzinSakit::whereIn('user_id', $pklIds)
            ->where('tanggal', '<=', $selectedDate)
            ->where(function ($q) use ($selectedDate) {
                $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $selectedDate);
            })
            ->where('status_approval', 'approved')
            ->get()
            ->keyBy('user_id');

        $hadir = 0;
        $belumAbsen = 0;
        $izinSakit = 0;

        foreach ($pklUsers as $user) {
            if ($izinSakitsToday->has($user->id)) {
                $izinSakit++;
            } elseif ($absensisToday->has($user->id) && $absensisToday[$user->id]->jam_masuk) {
                $hadir++;
            } else {
                $belumAbsen++;
            }
        }

        $query = Absensi::with('user');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->input('tanggal'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'hadir') {
                $query->whereNotNull('jam_masuk');
            } elseif ($request->input('status') === 'belum') {
                $query->whereNull('jam_masuk');
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nisp', 'like', "%{$search}%");
            });
        }

        $allAbsensis = $query->latest('tanggal')->paginate(15);

        $izinQuery = IzinSakit::with('user');

        if ($request->filled('status_izin')) {
            $izinQuery->where('status_approval', $request->input('status_izin'));
        }

        if ($request->filled('jenis_izin')) {
            $izinQuery->where('jenis', $request->input('jenis_izin'));
        }

        $izinSakits = $izinQuery->latest()->paginate(10, ['*'], 'izin_page');

        return view('admin.absensi.index', [
            'pklUsers' => $pklUsers,
            'absensisToday' => $absensisToday,
            'izinSakitsToday' => $izinSakitsToday,
            'hadir' => $hadir,
            'belumAbsen' => $belumAbsen,
            'izinSakitCount' => $izinSakit,
            'allAbsensis' => $allAbsensis,
            'izinSakits' => $izinSakits,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function destroyAbsensi(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }

    public function approve(IzinSakit $izinSakit): RedirectResponse
    {
        $izinSakit->update([
            'status_approval' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.absensi.index')->with('success', 'Pengajuan disetujui.');
    }

    public function reject(IzinSakit $izinSakit): RedirectResponse
    {
        $izinSakit->update([
            'status_approval' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.absensi.index')->with('success', 'Pengajuan ditolak.');
    }

    public function destroyIzinSakit(IzinSakit $izinSakit): RedirectResponse
    {
        $izinSakit->delete();

        return redirect()->route('admin.absensi.index')->with('success', 'Data izin/sakit berhasil dihapus.');
    }
}
