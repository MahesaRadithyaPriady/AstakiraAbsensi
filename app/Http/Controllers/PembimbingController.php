<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembimbingController extends Controller
{
    public function index(): View
    {
        $pembimbings = User::where('role', 'pembimbing')
            ->withCount('anakPkl')
            ->latest()
            ->paginate(10);

        return view('admin.pembimbing.index', [
            'pembimbings' => $pembimbings,
        ]);
    }

    public function show(User $pembimbing): View
    {
        $pembimbing->load('anakPkl');

        $assignedIds = $pembimbing->anakPkl->pluck('id')->toArray();

        $availablePkls = User::where('role', 'pkl')
            ->whereNotIn('id', $assignedIds)
            ->orderBy('nama')
            ->get();

        return view('admin.pembimbing.show', [
            'pembimbing' => $pembimbing,
            'availablePkls' => $availablePkls,
        ]);
    }

    public function assign(Request $request, User $pembimbing): RedirectResponse
    {
        $request->validate([
            'pkl_ids' => ['required', 'array'],
            'pkl_ids.*' => ['exists:users,id'],
        ]);

        $pembimbing->anakPkl()->syncWithoutDetaching($request->input('pkl_ids'));

        return redirect()
            ->route('admin.pembimbing.show', $pembimbing)
            ->with('success', 'Anak PKL berhasil ditambahkan.');
    }

    public function unassign(User $pembimbing, User $pkl): RedirectResponse
    {
        $pembimbing->anakPkl()->detach($pkl->id);

        return redirect()
            ->route('admin.pembimbing.show', $pembimbing)
            ->with('success', 'Anak PKL berhasil dilepas.');
    }
}
