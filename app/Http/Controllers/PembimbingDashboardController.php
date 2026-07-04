<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\IzinSakit;
use App\Models\Laporan;
use App\Models\Sop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class PembimbingDashboardController extends Controller
{
    public function index(): View
    {
        $pembimbing = Auth::user();
        $anakPklIds = $pembimbing->anakPkl()->pluck('users.id')->toArray();

        $today = now()->toDateString();

        $stats = [
            'total_anak' => count($anakPklIds),
            'hadir_hari_ini' => 0,
            'izin_sakit_hari_ini' => 0,
            'belum_absen_hari_ini' => 0,
            'laporan_pending' => 0,
            'total_sop' => Sop::active()->count(),
        ];

        if (!empty($anakPklIds)) {
            $absensiToday = Absensi::whereIn('user_id', $anakPklIds)
                ->where('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->count();
            $stats['hadir_hari_ini'] = $absensiToday;

            $izinToday = IzinSakit::whereIn('user_id', $anakPklIds)
                ->where('tanggal', '<=', $today)
                ->where(function ($q) use ($today) {
                    $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $today);
                })
                ->where('status_approval', 'approved')
                ->count();
            $stats['izin_sakit_hari_ini'] = $izinToday;
            $stats['belum_absen_hari_ini'] = $stats['total_anak'] - $stats['hadir_hari_ini'] - $stats['izin_sakit_hari_ini'];

            $stats['laporan_pending'] = Laporan::whereIn('user_id', $anakPklIds)
                ->where('status', 'pending')
                ->count();
        }

        $anakPkl = $pembimbing->anakPkl()->orderBy('nama')->get();

        $absensiHariIni = Absensi::whereIn('user_id', $anakPklIds)
            ->where('tanggal', $today)
            ->get()
            ->keyBy('user_id');

        $izinHariIni = IzinSakit::whereIn('user_id', $anakPklIds)
            ->where('tanggal', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $today);
            })
            ->where('status_approval', 'approved')
            ->get()
            ->keyBy('user_id');

        $laporanTerbaru = Laporan::with('user')
            ->whereIn('user_id', $anakPklIds)
            ->latest('tanggal')
            ->take(5)
            ->get();

        $attendanceData = Absensi::whereIn('user_id', $anakPklIds)
            ->where('tanggal', '>=', Carbon::now()->subDays(6))
            ->select('tanggal', DB::raw('count(*) as count'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $izinData = IzinSakit::whereIn('user_id', $anakPklIds)
            ->where('tanggal', '>=', Carbon::now()->subDays(6))
            ->select('tanggal', DB::raw('count(*) as count'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $chartLabels = [];
        $chartHadir = [];
        $chartIzin = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->translatedFormat('d M');

            $chartLabels[] = $label;

            $hadirCount = 0;
            foreach ($attendanceData as $data) {
                if ($data->tanggal->format('Y-m-d') === $date) {
                    $hadirCount = $data->count;
                    break;
                }
            }
            $chartHadir[] = $hadirCount;

            $izinCount = 0;
            foreach ($izinData as $data) {
                if ($data->tanggal->format('Y-m-d') === $date) {
                    $izinCount = $data->count;
                    break;
                }
            }
            $chartIzin[] = $izinCount;
        }

        return view('pembimbing.dashboard', [
            'pembimbing' => $pembimbing,
            'stats' => $stats,
            'anakPkl' => $anakPkl,
            'absensiHariIni' => $absensiHariIni,
            'izinHariIni' => $izinHariIni,
            'laporanTerbaru' => $laporanTerbaru,
            'chartLabels' => $chartLabels,
            'chartHadir' => $chartHadir,
            'chartIzin' => $chartIzin,
        ]);
    }
}
