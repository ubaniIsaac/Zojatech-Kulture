<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Cart extends Model
{
    use HasFactory;


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): belongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function beats(): HasMany
    {
        return $this->hasMany(Beat::class);
    }
}
