<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Cart extends Model
{
    use HasFactory , HasUlids;
    protected $fillable = [
        'user_id',
        'beats_id', 
        'items',
        'total_price',
    ];
    protected $casts = [
        'items' => 'array', // Cast the JSON column to an array
    ];

    public function beat(): HasMany
    {
        return $this->hasMany(Beat::class, 'id', 'items');
    }
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
