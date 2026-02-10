<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use SoftDeletes;

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
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];


    public function subdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class);
    }

    public function district()
    {
        return $this->subdistrict->district;
    }

    public function city()
    {
        return $this->district->city;
    }

    public function province()
    {
        return $this->city->province;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
