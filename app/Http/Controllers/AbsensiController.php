<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\IzinSakit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $absensiToday = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        $izinSakitToday = IzinSakit::where('user_id', $user->id)
            ->where('tanggal', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $today);
            })
            ->whereIn('status_approval', ['pending', 'approved'])
            ->first();

        $riwayatAbsensi = Absensi::where('user_id', $user->id)
            ->latest('tanggal')
            ->take(7)
            ->get();

        $riwayatIzin = IzinSakit::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pkl.absensi', [
            'absensiToday' => $absensiToday,
            'izinSakitToday' => $izinSakitToday,
            'riwayatAbsensi' => $riwayatAbsensi,
            'riwayatIzin' => $riwayatIzin,
        ]);
    }

    public function generateQr(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $izinSakitActive = IzinSakit::where('user_id', $user->id)
            ->where('tanggal', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $today);
            })
            ->where('status_approval', 'approved')
            ->first();

        if ($izinSakitActive) {
            $sampai = $izinSakitActive->sampai_tanggal
                ? $izinSakitActive->sampai_tanggal->format('d M Y')
                : $izinSakitActive->tanggal->format('d M Y');

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Anda sedang ' . $izinSakitActive->jenis . ' sampai ' . $sampai . '. Tidak dapat absensi.',
                ], 403);
            }

            return back()->with('error', 'Anda sedang ' . $izinSakitActive->jenis . ' sampai ' . $sampai . '. Tidak dapat absensi.');
        }

        $token = Str::random(32);
        $expiredAt = now()->addMinute();

        $absensi = Absensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['jam_masuk' => null]
        );

        $absensi->update([
            'qrcode_token' => $token,
            'qrcode_expired_at' => $expiredAt,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'token' => $token,
                'expired_at' => $expiredAt->toIso8601String(),
                'qr_data' => route('pkl.absensi.scan', ['token' => $token]),
            ]);
        }

        return back();
    }

    public function scan(string $token)
    {
        $absensi = Absensi::where('qrcode_token', $token)->first();

        if (!$absensi) {
            return response()->json(['success' => false, 'message' => 'QR code tidak valid.'], 404);
        }

        if ($absensi->qrcode_expired_at && now()->gt($absensi->qrcode_expired_at)) {
            return response()->json(['success' => false, 'message' => 'QR code telah kedaluwarsa.'], 410);
        }

        if ($absensi->jam_masuk) {
            return response()->json(['success' => false, 'message' => 'Sudah absen hari ini.'], 409);
        }

        $izinSakitActive = IzinSakit::where('user_id', $absensi->user_id)
            ->where('tanggal', '<=', $absensi->tanggal)
            ->where(function ($q) use ($absensi) {
                $q->whereNull('sampai_tanggal')->orWhere('sampai_tanggal', '>=', $absensi->tanggal);
            })
            ->where('status_approval', 'approved')
            ->first();

        if ($izinSakitActive) {
            return response()->json(['success' => false, 'message' => 'User sedang ' . $izinSakitActive->jenis . '. Tidak dapat absensi.'], 403);
        }

        $absensi->update([
            'jam_masuk' => now()->format('H:i:s'),
            'qrcode_token' => null,
            'qrcode_expired_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Jam masuk: ' . now()->format('H:i') . ' WIB',
            'jam_masuk' => now()->format('H:i'),
        ]);
    }

    public function check(string $token)
    {
        $absensi = Absensi::where('qrcode_token', $token)->first();

        if (!$absensi) {
            // Token might have been cleared after successful scan
            // Check if user already has jam_masuk today
            $todayAbsensi = Absensi::where('user_id', Auth::id())
                ->where('tanggal', now()->toDateString())
                ->whereNotNull('jam_masuk')
                ->first();

            if ($todayAbsensi) {
                return response()->json([
                    'scanned' => true,
                    'jam_masuk' => \Carbon\Carbon::parse($todayAbsensi->jam_masuk)->format('H:i'),
                ]);
            }

            return response()->json(['scanned' => false]);
        }

        if ($absensi->jam_masuk) {
            return response()->json([
                'scanned' => true,
                'jam_masuk' => \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i'),
            ]);
        }

        return response()->json(['scanned' => false]);
    }

    public function izinSakit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:izin,sakit'],
            'tanggal' => ['required', 'date'],
            'sampai_tanggal' => ['nullable', 'date', 'after_or_equal:tanggal'],
            'keterangan' => ['required', 'string', 'max:500'],
            'surat' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,webp', 'max:2048'],
        ]);

        $path = $request->file('surat')->store('surat-izin-sakit', 'public');

        IzinSakit::create([
            'user_id' => Auth::id(),
            'jenis' => $validated['jenis'],
            'tanggal' => $validated['tanggal'],
            'sampai_tanggal' => $validated['sampai_tanggal'] ?? null,
            'keterangan' => $validated['keterangan'],
            'surat' => $path,
            'status_approval' => 'pending',
        ]);

        return redirect()->route('pkl.absensi')->with('success', 'Pengajuan ' . $validated['jenis'] . ' berhasil dikirim, menunggu persetujuan admin.');
    }
}
