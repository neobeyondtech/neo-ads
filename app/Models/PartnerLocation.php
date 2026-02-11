<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id',
        'latitude',
        'longitude',
        'speed',
        'heading',
        'accuracy',
        'altitude',
        'status',
        'remarks',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'heading' => 'float',
        'accuracy' => 'float',
        'altitude' => 'float',
        'recorded_at' => 'datetime',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
