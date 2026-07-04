<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSopController extends Controller
{
    public function index()
    {
        $sops = Sop::with('creator')
            ->ordered()
            ->paginate(15);

        return view('admin.sop.index', compact('sops'));
    }

    public function create()
    {
        return view('admin.sop.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('sop', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Sop::create($validated);

        return redirect()->route('admin.sop.index')->with('success', 'SOP berhasil ditambahkan.');
    }

    public function edit(Sop $sop)
    {
        return view('admin.sop.edit', compact('sop'));
    }

    public function update(Request $request, Sop $sop)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('file')) {
            if ($sop->file_path) {
                Storage::disk('public')->delete($sop->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('sop', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $sop->update($validated);

        return redirect()->route('admin.sop.index')->with('success', 'SOP berhasil diperbarui.');
    }

    public function destroy(Sop $sop)
    {
        if ($sop->file_path) {
            Storage::disk('public')->delete($sop->file_path);
        }

        $sop->delete();

        return back()->with('success', 'SOP berhasil dihapus.');
    }
}
