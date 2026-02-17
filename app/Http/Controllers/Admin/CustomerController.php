<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    use HasPermissions;

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $search = $request->get('search', '');
        $query = Customer::with('users','type','category','subdistrict','district','city','province');
        
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('users', function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%");
                });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15);


        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }
 
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('create', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'NPWP_number' => 'nullable|string',
            'customer_type_id' => 'nullable',
            'customer_category_id' => 'nullable',
            'subdistrict_id' => 'nullable',
            'district_id' => 'nullable',
            'city_id' => 'nullable',
            'province_id' => 'nullable',
        ]);

        Customer::create($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show(Customer $customer)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('view', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.customers.show', compact('customer'));
    }

   public function edit(Customer $customer)
    {
        $user = Auth::user();
        if (!$user->role->canPerform('edit', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        // Muat relasi lokasi
        $customer->load('province', 'city', 'district', 'subdistrict');

        // Siapkan data lokasi untuk dropdown
        $locationData = [
            'province_id'      => $customer->province->id ?? null,
            'province_name'    => $customer->province->name ?? null,
            'city_id'          => $customer->city->id ?? null,
            'city_name'        => $customer->city->name ?? null,
            'district_id'      => $customer->district->id ?? null,
            'district_name'    => $customer->district->name ?? null,
            'subdistrict_id'   => $customer->subdistrict->id ?? null,
            'subdistrict_name' => $customer->subdistrict->name ?? null,
        ];

        return view('admin.customers.edit', compact('customer', 'locationData'));
    }

    public function update(Request $request, Customer $customer)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('edit', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'NPWP_number' => 'nullable|string',
            'customer_type_id' => 'nullable',
            'customer_category_id' => 'nullable',
            'subdistrict_id' => 'nullable',
            'district_id' => 'nullable',
            'city_id' => 'nullable',
            'province_id' => 'nullable',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully');
    }

    public function destroy(Customer $customer)
    {
        $user = Auth::user();

        if (!$user->role->canPerform('delete', 'customers')) {
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully');
    }
}
