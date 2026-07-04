<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use Illuminate\View\View;

class PembimbingSopController extends Controller
{
    public function index(): View
    {
        $sops = Sop::active()->ordered()->get();

        return view('pembimbing.sop.index', compact('sops'));
    }

    public function show(Sop $sop): View
    {
        if (!$sop->is_active) {
            abort(404);
        }

        return view('pembimbing.sop.show', compact('sop'));
    }
}
