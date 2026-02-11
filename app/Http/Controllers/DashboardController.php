<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalIklan = Iklan::where('user_id', $user->id)->count();
        
        return view('customer.dashboard.index', [
            'user' => $user,
            'totalIklan' => $totalIklan,
        ]);
    }
}