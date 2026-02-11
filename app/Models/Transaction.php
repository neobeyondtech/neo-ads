<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use hasFactory, SoftDeletes;

    protected $fillable = [
        'ad_id',
        'customer_id',
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
    public function ad()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
