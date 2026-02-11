<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Deposit;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use HasPermissions;

    public function index()
    {
        $user = Auth::user();

        // Check permission to view transactions
        $viewPermissionLevel = $this->getViewPermissionLevel('my-payment');
        if (!$viewPermissionLevel) {
            return redirect()->route('my-dashboard')->with('error', 'You do not have permission to view payments.');
        }

        // Get all transactions for user's advertisements
        $transactions = Transaction::whereHas('advertisement', function ($query) use ($user) {
            $query->where('customer_id', $user->id);
        })
            ->with(['advertisement'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get deposit history
        $transactionDeposits = [];

        // Calculate total deposit
        $balance = 0;

        return view('customer.payment.index', compact('transactions', 'transactionDeposits', 'balance'));
    }
}