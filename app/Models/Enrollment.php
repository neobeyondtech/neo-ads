<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'advertisement_id',
        'partner_id',
        'status',
        'remarks',
        'rate',
        'achievement',
        'start_date',
        'end_date',
        'approved_at',
        'rejected_at',
        'canceled_at',
        'completed_at',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'end_date'     => 'date',
        'approved_at'  => 'datetime',
        'rejected_at'  => 'datetime',
        'canceled_at'  => 'datetime',
        'completed_at' => 'datetime',
        'rate'         => 'decimal:2',
    ];

    // Relationships
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
