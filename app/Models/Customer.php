<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'customer_type_id',
        'customer_category_id',
        'description',
        'NPWP_number',
        'master_location_id',
        'address',
    ];

    // Relationships (optional)
    public function type()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class, 'master_location_id');
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
    }

    public function category()
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
    }

    public function users()
    {
        return $this->hasMany(CustomerUser::class);
    }

    //muttator name to uppercase each word
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    //mutator NPWP_number to only accept digits
    public function setNPWPNumberAttribute($value)
    {
        $this->attributes['NPWP_number'] = preg_replace('/\D/', '', $value);
    }
}
