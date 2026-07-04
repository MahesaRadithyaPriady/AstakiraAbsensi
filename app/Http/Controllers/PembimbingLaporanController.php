<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PembimbingLaporanController extends Controller
{
    public function index(Request $request): View
    {
        $pembimbing = Auth::user();
        $anakPklIds = $pembimbing->anakPkl()->pluck('users.id')->toArray();

        $query = Laporan::with(['user', 'validator'])
            ->whereIn('user_id', $anakPklIds);

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
            'total' => Laporan::whereIn('user_id', $anakPklIds)->count(),
            'pending' => Laporan::whereIn('user_id', $anakPklIds)->where('status', 'pending')->count(),
            'validated' => Laporan::whereIn('user_id', $anakPklIds)->where('status', 'validated')->count(),
            'rejected' => Laporan::whereIn('user_id', $anakPklIds)->where('status', 'rejected')->count(),
        ];

        return view('pembimbing.laporan.index', compact('laporans', 'stats'));
    }

    public function show(Laporan $laporan): View
    {
        $pembimbing = Auth::user();
        $anakPklIds = $pembimbing->anakPkl()->pluck('users.id')->toArray();

        if (!in_array($laporan->user_id, $anakPklIds)) {
            abort(403);
        }

        $laporan->load(['user', 'validator']);

        return view('pembimbing.laporan.show', compact('laporan'));
    }
}
