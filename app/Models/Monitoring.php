<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoring extends Model
{
    protected $fillable = [
        'advertisement_id',
        'total_target',
        'total_achieved',
        'progress_percent',
        'status',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function getProgressPercentAttribute()
    {
        if ($this->total_target == 0) return 0;

        return round(($this->total_achieved / $this->total_target) * 100);
    }
}
