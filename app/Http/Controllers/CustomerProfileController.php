<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerUser;
use App\Models\CustomerType;
use App\Models\CustomerCategory;
use App\Models\User;
use App\Models\Location;
use App\Models\Penanggung_jawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Facades\ActivityLog;

class CustomerProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $customer_user = CustomerUser::where('user_id', $user->id)->first();
        $customer = $customer_user?->customer->first() ?? null;
        // Load location relationships for default values
        $locationData = null;
        if ($customer && $customer->subdistrict) {
            
            $locationData = [
                'province_id' => $customer->province->id ?? null,
                'province_name' => $customer->province->name ?? null,
                'city_id' => $customer->city->id ?? null,
                'city_name' => $customer->city->name ?? null,
                'district_id' => $customer->district->id ?? null,
                'district_name' => $customer->district->name ?? null,
                'subdistrict_id' => $customer->subdistrict->id ?? null,
                'subdistrict_name' => $customer->subdistrict->name ?? null,
            ];
        }  
        
        $options = [
            'customer_type' => CustomerType::get(),
            'customer_category' => CustomerCategory::get()
        ];
        return view('customer.profile.index', compact('customer','customer_user', 'options', 'locationData'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_category_id' => 'required|exists:customer_categories,id',
            'customer_type_id' => 'required|exists:customer_types,id',
            'npwp' => 'nullable|string|max:20',
            'subdistrict_id' => 'required|exists:master_subdistricts,id',
            'address' => 'required|string',
        ],
        [
            'customer_name.required' => 'Nama perusahaan wajib diisi.',
            'customer_category_id.required' => 'Kategori perusahaan wajib diisi.',
            'customer_category_id.exists' => 'Kategori perusahaan yang dipilih tidak valid.',
            'customer_type_id.required' => 'Jenis perusahaan wajib diisi.',
            'customer_type_id.exists' => 'Jenis perusahaan yang dipilih tidak valid.',
            'subdistrict_id.required' => 'Kelurahan wajib diisi.',
            'subdistrict_id.exists' => 'Kelurahan yang dipilih tidak valid.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $user = Auth::user();
        
        $customer = Customer::where('id', $request->customer_id)->first();
        
        if (!$customer) {
            $customer = new Customer();
        }

        DB::beginTransaction();
        try {
            $customer->name = $request->customer_name;
            $customer->customer_category_id = $request->customer_category_id;
            $customer->customer_type_id = $request->customer_type_id;
            $customer->NPWP_number = $request->npwp;
            $customer->master_location_id = $request->subdistrict_id;
            $customer->address = $request->address;
            $customer->save();

            $customerUser = CustomerUser::where('user_id', $user->id)->first();
            if (!$customerUser) {
                $customerUser = new CustomerUser();
                $names = explode(' ', $user->name);
                $customerUser->user_id = $user->id;
                $customerUser->first_name = $names[0] ?? 'Anonim';
                $customerUser->last_name = $names[count($names) - 1] ?? '';
            }
            $customerUser->customer_id = $customer->id;
            $customerUser->save();
            DB::commit();
            ActivityLog::logUpdated('customer', 'Updated customer', 'App\Models\Customer', $customer->id, $customer->toArray());
            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating customer profile: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }
    }
    
    public function updateContact(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'customer_user_first_name' => 'required|string|max:100',
            'customer_user_last_name' => 'nullable|string|max:100',
            'customer_user_email' => 'nullable|email|max:100', 
            'customer_user_phone' => 'required|string|max:20',
        ],
        [
            'customer_user_first_name.required' => 'Nama depan wajib diisi.',
            'customer_user_first_name.max' => 'Nama depan maksimal 100 karakter.',
            'customer_user_last_name.max' => 'Nama belakang maksimal 100 karakter.',
            'customer_user_email.email' => 'Format email tidak valid.',
            'customer_user_email.max' => 'Email maksimal 100 karakter.',
            'customer_user_phone.required' => 'Nomor telepon wajib diisi.',
            'customer_user_phone.max' => 'Nomor telepon maksimal 20 digit.',
        ]);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            if($request->customer_user_email && $request->customer_user_email !== $user->email) {
                $emailExists = User::where('email', $request->customer_user_email)
                    ->where('id', '!=', $user->id)
                    ->exists();
                if ($emailExists) {
                    return back()->withErrors(['customer_user_email' => 'Email sudah digunakan oleh pengguna lain.'])->withInput();
                }
                $user->email = $request->customer_user_email;
                $user->save();
            }
            
            $customer_user = CustomerUser::where('user_id', $user->id)
                                            ->where('customer_id', $request->customer_id)
                                            ->first();
            
            if (!$customer_user) {
                $customer_user = new CustomerUser();
                $customer_user->user_id = $user->id;
            }

            $customer_user->customer_id = $request->customer_id;
            $customer_user->first_name = $request->customer_user_first_name;
            $customer_user->last_name = $request->customer_user_last_name;
            $customer_user->phone = $request->customer_user_phone;
            $customer_user->save();
            DB::commit();
            ActivityLog::logUpdated('customer_user', 'Updated customer contact profile for customer user ID ' . $customer_user->id, 'App\Models\CustomerUser', $customer_user->id, $customer_user->toArray());
            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating customer contact profile: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }   
    }
}