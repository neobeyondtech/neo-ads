<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id',
        'type',
        'vehicle_brand_id',
        'vehicles_colour',
        'vehicles_year',
        'img_front',
        'img_left',
        'img_right',
        'img_back',
        'img_stnk',
        'plat_number',
    ];

    protected $casts = [
        'vehicles_year' => 'integer',
    ];

    function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    function vehicleBrand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }
}
