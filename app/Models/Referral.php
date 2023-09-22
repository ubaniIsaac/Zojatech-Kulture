<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code',
        'referred_by',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_code', 'referral_code');
    }


    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by', 'referral_code');
    }

    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }
}
