<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PklDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $user->load('pembimbing');

        return view('pkl.dashboard', [
            'user' => $user,
        ]);
    }
}
