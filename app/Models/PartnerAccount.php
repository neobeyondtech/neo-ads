<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id',
        'account_number',
        'account_name',
        'bank_id',
        'account_type',
        'remarks',
    ];

    function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    function bank()
    {
        return $this->belongsTo(MasterBank::class, 'bank_id');
    }
}
