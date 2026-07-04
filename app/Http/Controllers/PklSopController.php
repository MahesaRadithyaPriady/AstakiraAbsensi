<?php

namespace App\Http\Controllers;

use App\Models\Sop;

class PklSopController extends Controller
{
    public function index()
    {
        $sops = Sop::active()->ordered()->get();

        return view('pkl.sop.index', compact('sops'));
    }

    public function show(Sop $sop)
    {
        if (!$sop->is_active) {
            abort(404);
        }

        return view('pkl.sop.show', compact('sop'));
    }
}
