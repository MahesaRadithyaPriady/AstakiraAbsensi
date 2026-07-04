<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\IzinSakit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PembimbingAbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $pembimbing = Auth::user();
        $anakPklIds = $pembimbing->anakPkl()->pluck('users.id')->toArray();

        $today = now()->toDateString();
        $selectedDate = $request->input('tanggal', $today);

        $anakPkl = User::whereIn('id', $anakPklIds)->orderBy('nama')->get();

        $absensisToday = Absensi::whereIn('user_id', $anakPklIds)
            ->where('tanggal', $selectedDate)
            ->get()
            ->keyBy('user_id');

        $izinSakitsToday = IzinSakit::whereIn('user_id', $anakPklIds)
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

        foreach ($anakPkl as $user) {
            if ($izinSakitsToday->has($user->id)) {
                $izinSakit++;
            } elseif ($absensisToday->has($user->id) && $absensisToday[$user->id]->jam_masuk) {
                $hadir++;
            } else {
                $belumAbsen++;
            }
        }

        $query = Absensi::with('user')->whereIn('user_id', $anakPklIds);

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->input('tanggal'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisp', 'like', "%{$search}%");
            });
        }

        $allAbsensis = $query->latest('tanggal')->paginate(15);

        $izinQuery = IzinSakit::with('user')->whereIn('user_id', $anakPklIds);

        if ($request->filled('status_izin')) {
            $izinQuery->where('status_approval', $request->input('status_izin'));
        }

        $izinSakits = $izinQuery->latest()->paginate(10, ['*'], 'izin_page');

        return view('pembimbing.absensi.index', [
            'anakPkl' => $anakPkl,
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
}
