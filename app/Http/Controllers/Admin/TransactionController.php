<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;

class TransactionController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = Transaction::with('advertisement','customer');

        if ($status && $status !== 'all') {
            $query->where('payment_status', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = PaymentStatus::options();

        return view('admin.transactions.index', compact('transactions', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.transactions.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'advertisement_id' => 'nullable|exists:advertisements,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'payment_reference' => 'nullable|string',
            'payment_date' => 'nullable',
            'payment_channel' => 'nullable',
            'transaction_reference' => 'nullable',
            'payment_status' => 'required|string',
            'payment_notes' => 'nullable|string',
        ]);

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully');
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $statuses = PaymentStatus::options();
        $methods = PaymentMethod::options();

        return view('admin.transactions.edit', compact('transaction', 'statuses', 'methods'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'advertisement_id' => 'nullable|exists:advertisements,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'payment_reference' => 'nullable|string',
            'payment_date' => 'nullable',
            'payment_channel' => 'nullable',
            'transaction_reference' => 'nullable',
            'payment_status' => 'required|string',
            'payment_notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy(Transaction $transaction)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'transactions')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
