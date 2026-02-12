<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\Transaction;
use App\Traits\HasPermissions;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        // Check admin permission
        if (!$user->role->canPerform('view', 'advertisements')) {
            return redirect()->route('my-dashboard')->with('error', 'You do not have permission to access admin panel.');
        }

        // Get dashboard statistics
        $totalAdvertisements = Advertisement::count();
        $totalCustomers = Customer::count();
        $totalPartners = Partner::count();
        $totalTransactions = Transaction::sum('amount');

        $recentAdvertisements = Advertisement::latest()->limit(5)->get();
        $recentTransactions = Transaction::with('advertisement')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalAdvertisements',
            'totalCustomers',
            'totalPartners',
            'totalTransactions',
            'recentAdvertisements',
            'recentTransactions'
        ));
    }
}
