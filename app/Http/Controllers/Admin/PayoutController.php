<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\Partner;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{ 
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $status = $request->get('status', '');
        $query = Payout::with('partner','advertisement');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $payouts = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = Payout::distinct()->pluck('payment_status')->sort()->values()->toArray();

        return view('admin.payouts.index', compact('payouts', 'statuses', 'status'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $partners = Partner::all();
        return view('admin.payouts.create', compact('partners'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'advertisement_id' => 'required|exists:advertisements,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_date' => 'required',
            'payment_channel' => 'nullable',
            'transaction_reference' => 'nullable',
            'payment_notes' => 'nullable|string',
        ]);

        Payout::create($validated);

        return redirect()->route('admin.payouts.index')->with('success', 'Payout created successfully');
    }

    public function show(Payout $payout)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.payouts.show', compact('payout'));
    }

    public function edit(Payout $payout)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $partners = Partner::all();
        return view('admin.payouts.edit', compact('payout', 'partners'));
    }

    public function update(Request $request, Payout $payout)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'advertisement_id' => 'required|exists:advertisements,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_date' => 'required',
            'payment_channel' => 'nullable',
            'transaction_reference' => 'nullable',
            'payment_notes' => 'nullable|string',
        ]);

        $payout->update($validated);

        return redirect()->route('admin.payouts.show', $payout)->with('success', 'Payout updated successfully');
    }

    public function destroy(Payout $payout)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'payouts')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $payout->delete();

        return redirect()->route('admin.payouts.index')->with('success', 'Payout deleted successfully');
    }
}
