<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\StickerAreaType;
use App\Enums\GoalType;
use App\Enums\OrderStatus;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'city_id',
        'title',
        'goal_type',
        'sticker_area_type',
        'target_location_id',
        'target_distance',
        'target_partner',
        'total_budget',
        'startdate',
        'enddate',
        'duration',
        'status',
        'description',
        'remarks',
        'draft_at',
        'on_review_at',
        'searching_partner_at',
        'start_at',
        'completed_at',
        'cancel_at',
    ];

    protected $casts = [
        'startdate' => 'date',
        'enddate'   => 'date',
        'total_budget' => 'decimal:2',
        'draft_at' => 'datetime',
        'on_review_at' => 'datetime',
        'searching_partner_at' => 'datetime',
        'start_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancel_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function location()
    {
        return $this->belongsTo(MasterCity::class, 'target_location_id');
    }

    public function city()
    {
        return $this->belongsTo(MasterCity::class, 'city_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function stickers()
    {
        return $this->hasMany(AdvertisementSticker::class);
    }
    
    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'enrollments', 'advertisement_id', 'partner_id');
    }

    public function reports()
    {
        return $this->hasMany(PartnerReport::class, 'advertisement_id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'advertisement_id');
    }

    public static function calculatePrice($stickerAreaType, $targetPartner, $targetDistance)
    {
        $price = StickerAreaType::from($stickerAreaType)->price();
        $cost = StickerAreaType::from($stickerAreaType)->cost();

        $total = ($price * $targetDistance) + ($targetPartner * $cost);
        return $total;
    }

    public function getGoalTypeLabelAttribute()
    {
        return GoalType::tryFrom($this->goal_type)?->label() ?? $this->goal_type;
    }

    public function getStickerAreaTypeLabelAttribute()
    {
        return StickerAreaType::tryFrom($this->sticker_area_type)?->label() ?? $this->sticker_area_type;
    }

    public function getAllowCancelAttribute()
    {
        if (in_array($this->status, [OrderStatus::DRAFT->value, OrderStatus::ON_REVIEW->value])) {
            return true;
        }
        return false;
    }
}
