<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code',
        'referred_by',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'referral_code', 'referral_code');
    }


    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'referral_code');
    }

    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }
}
