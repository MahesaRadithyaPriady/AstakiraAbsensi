<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\IzinSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_karyawan' => User::where('role', 'karyawan')->count(),
            'total_pkl' => User::where('role', 'pkl')->count(),
            'total_pembimbing' => User::where('role', 'pembimbing')->count(),
        ];

        $recent_users = User::latest()->limit(5)->get();

        // Get attendance count for the last 7 days (including today)
        $attendanceData = Absensi::where('tanggal', '>=', Carbon::now()->subDays(6))
            ->select('tanggal', DB::raw('count(*) as count'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Get izin/sakit count for the last 7 days (including today)
        $izinData = IzinSakit::where('tanggal', '>=', Carbon::now()->subDays(6))
            ->select('tanggal', DB::raw('count(*) as count'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Prepare data for Chart
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

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'stats' => $stats,
            'recent_users' => $recent_users,
            'chartLabels' => $chartLabels,
            'chartHadir' => $chartHadir,
            'chartIzin' => $chartIzin,
        ]);
    }
}
