<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'plan',
        'description',
        'price',
        'upload_limit',
        
    ];

    /**
     * Get all of the users for the Subscription
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Producer>
     */

    public function users(): HasMany
    {
        return $this->hasMany(Producer::class);
    }

    public function scopeFree(): object
    {
        return $this->where('price', 0);
    }

    public function scopePaid(): object
    {
        return $this->where('price', '>', 0);
    }
}
