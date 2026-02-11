<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use hasFactory, SoftDeletes;

    protected $fillable = [
        'advertisement_id',
        'partner_id',
        'amount',
        'payment_status',
        'payment_method',
        'payment_date',
        'transaction_reference',
        'payment_channel',
        'payment_notes',
    ];

    //cast
    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
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
