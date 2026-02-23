<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    use HasPermissions;

    /**
     * Display monitoring list.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Permission check
        $viewPermissionLevel = $this->getViewPermissionLevel('my-monitoring');
        //dd($viewPermissionLevel);
        if (!$viewPermissionLevel) {
            return redirect()->route('my-dashboard')
                ->with('error', 'You do not have permission to view monitoring.');
        }

        $status = $request->get('status', '');

        /*
        |--------------------------------------------------------------------------
        | Query utama
        |--------------------------------------------------------------------------
        */
        if ($viewPermissionLevel === 'own') {
            $query = Monitoring::with(['advertisement'])
                ->whereHas('advertisement', function ($q) use ($user) {
                    $q->where('customer_id', $user->id);
                });
        } else {
            $query = Monitoring::with(['advertisement']);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $monitorings = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Status dropdown
        |--------------------------------------------------------------------------
        */
        $statuses = Monitoring::distinct()
            ->pluck('status')
            ->sort()
            ->values()
            ->toArray();
    
       // dd($monitorings);
        return view('customer.monitoring.index', compact(
            'monitorings',
            'statuses',
            'status'
        ));
    }
}