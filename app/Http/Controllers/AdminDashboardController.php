<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'stats' => $stats,
            'recent_users' => $recent_users,
        ]);
    }
}
