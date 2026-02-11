<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerReport extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'ad_id',
        'partner_id',
        'img_vehicle_stickers',
        'img_odometer',
        'actual_odometer',
        'remarks',
        'status',
        'location',
        'verified_at',
        'rejected_at',
        'reviewed_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'rejected_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function ad()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
