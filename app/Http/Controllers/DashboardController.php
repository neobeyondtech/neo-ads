<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addsCount = 0;
        
        return view('customer.dashboard.index', [
            'user' => $user,
            'addsCount' => $addsCount,
        ]);
    }
}