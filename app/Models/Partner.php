<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'phone',
        'no_ktp',
        'img_ktp',
        'no_sim',
        'img_sim',
        'subdistrict_id',
        'address',
        'email',
        'province',
        'city',
        'district',
        'village'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];


   /* public function subdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class);
    }

    public function getDistrictAttribute()
    {
        return $this->subdistrict->district??null;
    }

    public function getCityAttribute()
    {
        return $this->district->city??null;
    }

    public function getProvinceAttribute()
    {
        return $this->city->province??null;
    }*/
 
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    
    public function district()
    {
        return $this->belongsTo(MasterDistrict::class, 'district');
    }

    public function city()
    {
        return $this->belongsTo(MasterCity::class, 'city');
    }

    public function province()
    {
        return $this->belongsTo(MasterProvince::class, 'province');
    }
    
    
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
